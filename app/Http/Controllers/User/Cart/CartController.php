<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operation;
use App\Models\Operationdetailes;
use Auth;
use Session;

class CartController extends Controller
{
    // Helper function to calculate grouped cart count
    public static function getGroupedCartCount($order) {
        if (!$order || !$order->orderdetailes) {
            return 0;
        }

        $groups = [];
        foreach ($order->orderdetailes as $d) {
            $key = $d->opreationname;
            if ($d->opreationname === 'خامات' || $d->opreationname === 'خامات استاندرد') {
                $key = $d->opreationname.'|'.($d->material_name ?? '');
            }
            $groups[$key] = true;
        }
        return count($groups);
    }

    //
    public function index(){
        $order=Order::with(['orderdetailes.operation','orderdetailes.operationdetailes'])->where('user_id',Auth::user()->id)->where('status','unpaid')->first();
        $totalprcie=0;
        if($order!=null && $order->orderdetailes->count() > 0){
            foreach($order->orderdetailes as $detailes){
                $totalprcie+=$detailes->price;
            }
        } else {
            // If order exists but has no items, set it to null to show empty cart
            $order = null;
        }
        return view('User.cart.index',compact('order','totalprcie'));
    }
    public function checkout(Order $order){
        // Ensure the order belongs to the current user
        if ($order->user_id !== Auth::user()->id) {
            return redirect()->route('user.cart')->with('error', 'غير مصرح لك بالوصول لهذا الطلب');
        }

        if ($order->status === 'paied') {
            return redirect()->route('user.print', $order->id)->with('info', 'تم دفع هذا الطلب مسبقاً');
        }

        $totalprcie = 0;
        if($order->orderdetailes){
            foreach($order->orderdetailes as $detailes){
                $totalprcie += $detailes->price;
            }
        }

        return view('User.cart.checkout', compact('order', 'totalprcie'));
    }

    public function pay(Request $request, Order $order){
        try {
            // Ensure the order belongs to the current user
            if ($order->user_id !== Auth::user()->id) {
                return redirect()->route('user.cart')->with('error', 'غير مصرح لك بالوصول لهذا الطلب');
            }

            if ($order->status === 'paied') {
                return redirect()->route('user.print', $order->id)->with('info', 'تم دفع هذا الطلب مسبقاً');
            }

            $order->update([
                'status' => 'paied',
                'paid_at' => now(),
                'customer_name' => $request->input('customer_name'),
                'customer_phone' => $request->input('customer_phone'),
                'notes' => $request->input('notes'),
            ]);

            Session::put('orderqnty', 0);

            return redirect()->route('user.print', $order->id)->with('success', 'تم الدفع بنجاح! يمكنك الآن طباعة الفاتورة.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة الدفع. يرجى المحاولة مرة أخرى.');
        }
    }

    public function printById(Order $order = null){
        // If no order provided, get the most recent order
        if (!$order) {
            $order = Order::with(['orderdetailes.operation','orderdetailes.operationdetailes'])
                ->where('user_id', Auth::user()->id)
                ->orderBy('updated_at', 'desc')
                ->first();
        } else {
            // Ensure the order belongs to the current user
            if ($order->user_id !== Auth::user()->id) {
                return redirect()->route('user.cart')->with('error', 'غير مصرح لك بالوصول لهذا الطلب');
            }

            // Load relationships if not already loaded
            $order->load(['orderdetailes.operation','orderdetailes.operationdetailes']);
        }

        if (!$order) {
            return redirect()->route('user.cart')->with('error', 'لا توجد طلبات للطباعة');
        }

        $totalprcie = 0;
        if($order->orderdetailes){
            foreach($order->orderdetailes as $detailes){
                $totalprcie += $detailes->price;
            }
        }

        return view('User.cart.print', compact('order', 'totalprcie'));
    }

    // Optional endpoint: update customer fields from print page without changing status
    public function updateCustomer(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::user()->id) {
            return redirect()->route('user.cart')->with('error', 'غير مصرح لك بالوصول لهذا الطلب');
        }
        $order->update([
            'customer_name' => $request->input('customer_name'),
            'customer_phone' => $request->input('customer_phone'),
            'notes' => $request->input('notes'),
        ]);
        return redirect()->route('user.print', $order->id)->with('success', 'تم تحديث بيانات العميل');
    }

    public function bulkDeleteOrderDetailes(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم تحديد أي عناصر للحذف'
                ], 400);
            }

            // Get the current order
            $order = Order::with('orderdetailes')->where('user_id', Auth::user()->id)->where('status', 'unpaid')->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على الطلب'
                ], 404);
            }

            // Verify all IDs belong to this order
            $validIds = $order->orderdetailes->whereIn('id', $ids)->pluck('id')->toArray();

            if (count($validIds) !== count($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'بعض العناصر المحددة غير صحيحة'
                ], 400);
            }

            // Delete the order details
            Orderdetailes::whereIn('id', $validIds)->delete();

            // Update order quantities and total price
            $order->load('orderdetailes');
            $remainingCount = $order->orderdetailes->count();

            if ($remainingCount > 0) {
                $order->quantity = $remainingCount;
                $order->totalprice = $order->orderdetailes->sum('price');
                $order->save();
            } else {
                // If no items left, delete the order entirely
                $order->delete();
            }

            // Update session
            Session::put('orderqnty', $remainingCount);

            return response()->json([
                'success' => true,
                'message' => 'تم حذف العناصر المحددة بنجاح',
                'count' => $remainingCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف العناصر: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCartCount(){
        try {
            $order = Order::with('orderdetailes')->where('user_id', Auth::user()->id)->where('status', 'unpaid')->first();
            $count = $order ? $order->orderdetailes->count() : 0;

            return response()->json([
                'success' => true,
                'count' => $count,
                'message' => 'Cart count retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'count' => 0,
                'message' => 'Error retrieving cart count'
            ], 500);
        }
    }
}
