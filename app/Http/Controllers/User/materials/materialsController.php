<?php

namespace App\Http\Controllers\User\materials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operation;
use App\Models\Operationdetailes;
use App\Models\materials;
use Auth;
use Session;

class materialsController extends Controller {

    //
    function weight($thickness, $length, $width, $qty) {
        $weight = (7.85 / 10000) * ($thickness * $length * $width);
        return $weight * $qty;
    }

    public function index() {
        $materials_type = materials::select('name')->orderBy('id', 'ASC')->groupBy('name')->get();
        $materials_size = materials::select('size')->groupBy('size')->get();
        $order = Order::with(['orderdetailes.operationdetailes', 'orderdetailes' => function ($q) {
                        $q->where('operation_id', '=', 5);
                    }])->where('user_id', Auth::user()->id)->where('status', '=', 'unpaid')->first();
        error_log($order);
        return view('User.materials.index', compact('materials_type', 'materials_size', 'order'));
    }

    public function getSize(Request $request) {
        $materials_size = materials::select('size')->where('name', $request->name)->get();
        return $materials_size;
    }

//    public function getMaterial(materials obj){
//        
//    }



    public function materialsorder(Request $request) {
        $validated = $request->validate([
            'item' => 'required',
            'size' => 'required',
            'priceType' => 'required',
            'weight' => 'required',
        ]);
        // if($request->thickness>12){
        //   return redirect()->back();
        // }

        $price = materials::where('name', $request->item)->where('size', $request->size)->get();
        $itemObj = $price;
        $material_id = $price[0];
        if ($request->priceType == '0') {
            $price = $price[0]->wholesale_price;
        } else {
            $price = $price[0]->retail_price;
        }
        error_log($price . "");
        //     $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
        $order = Order::with('orderdetailes')->where('user_id', Auth::user()->id)->where('status', '=', 'unpaid')->first();
        if ($order != null) {
            $order->update([
                'quantity' => $order->quantity + 1,
            ]);
        }
        if ($order == null) {
            $order = Order::create([
                        'status' => 'unpaid',
                        'user_id' => Auth::user()->id,
                        'quantity' => 1,
            ]);
        }
        Session::put('orderqnty', $order->quantity);
        $Operationdetailes = Operationdetailes::create([
                    'operation_id' => 5,
                    'thickness' => $request->size,
                    'weight' => $request->weight,
                    'quantity' => 1,
        ]);
        $Orderdetailes = Orderdetailes::create([
                    'order_id' => $order->id,
                    'operation_id' => 5,
                    'quantity' => 1,
                    'operationdetailes_id' => $Operationdetailes->id,
                    'price' => $price*$request->weight,
                    'weight' => $request->weight,
                    'opreationname' => 'خامات',
                    'material_id' => $material_id->id,
                    'material_name' => $material_id->name
        ]);
        return redirect()->back();
    }

    public function deleteOrderDetailes($id) {
        $Orderdetailes = Orderdetailes::with('operationdetailes')->find($id);
        $Operationdetailes = Operationdetailes::find($Orderdetailes->operationdetailes_id)->delete();
        $order = Order::find($Orderdetailes->order_id);
        $order->update([
            'quantity' => $order->quantity - 1,
        ]);
        Session::put('orderqnty', $order->quantity);
        return redirect()->back();
    }

}
