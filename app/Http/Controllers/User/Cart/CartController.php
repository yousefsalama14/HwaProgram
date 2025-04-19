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
    //
    public function index(){
        $order=Order::with(['orderdetailes.operation','orderdetailes.operationdetailes'])->where('user_id',Auth::user()->id)->where('status','unpaid')->first();
        $totalprcie=0;
        if($order!=null){
            foreach($order->orderdetailes as $detailes){
                $totalprcie+=$detailes->price;
            }
        }
        return view('User.cart.index',compact('order','totalprcie'));
    }
    public function paied(Request $request){
       // dd($request->all());
        $order=Order::find($request->id);
        $order->update([
          'status'=>'paied'
        ]);
        Session::put('orderqnty',0);
        return redirect()->back();
    }
    public function print(){
        $order=Order::with(['orderdetailes.operation','orderdetailes.operationdetailes'])->where('user_id',Auth::user()->id)->where('status','unpaid')->first();
        $totalprcie=0;
        if($order!=null){
            foreach($order->orderdetailes as $detailes){
                $totalprcie+=$detailes->price;
            }
        }
        return view('User.cart.print',compact('order','totalprcie'));
    }
}
