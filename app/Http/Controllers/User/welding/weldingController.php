<?php

namespace App\Http\Controllers\User\welding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\weldingwire;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operation;
use App\Models\Operationdetailes;
use Auth;
use Session;
class weldingController extends Controller
{
    //
    public function index(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',1);
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.Welding.index',compact('order'));
    }
    public function weldingorder(Request $request){
        $validated = $request->validate([
            'thickness' => 'required',
            'length' => 'required',
            'passes' => 'required',
            'quantity' => 'required',
        ]);
        if($request->thickness>12){
          return redirect()->back();
        }
        if($request->thickness<=5){
                // if thickness <=5 use weilding wire 2.5
                 $weldingwire=weldingwire::find(1);
                if($request->thickness==1||$request->thickness==2){
                     $amount=$request->length/25;
                }
                if($request->thickness==3||$request->thickness==4){
                    $amount=$request->length/20;
                }
                if($request->thickness==5){
                    $amount=$request->length/17;
                }
               $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        }elseif($request->thickness>5 && $request->thickness<=8){

                 $weldingwire=weldingwire::find(2);
                 if($request->thickness==6){
                    $amount=$request->length/15;
                  }
                  if($request->thickness==7){
                    $amount=$request->length/14;
                 }
                if($request->thickness==8){
                    $amount=$request->length/12;
                }
                $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        }elseif($request->thickness>8 && $request->thickness<=12){
                $weldingwire=weldingwire::find(3);
                if($request->thickness==9){
                    $amount=$request->length/11;
                }
                if($request->thickness==10){
                    $amount=$request->length/10;
                }
                if($request->thickness==11){
                    $amount=$request->length/9;
                }
                if($request->thickness==12){
                    $amount=$request->length/8;
                }
                $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        }
       $order=Order::with('orderdetailes')->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        if($order!=null){
            $order->update([
                'quantity'=>$order->quantity+1,
             ]);
        }
        if($order==null){
            $order=Order::create([
                'status'=>'unpaid',
                'user_id'=>Auth::user()->id,
                'quantity'=>1,
            ]);
        }
      Session::put('orderqnty',$order->quantity);
        $Operationdetailes=Operationdetailes::create([
            'operation_id'=>1,
            'thickness'=>$request->thickness,
            'length'=>$request->length,
            'passes'=>$request->passes,
            'quantity'=>$request->quantity,
        ]);
        $Orderdetailes=Orderdetailes::create([
          'order_id'=>$order->id,
          'operation_id'=>1,
          'quantity'=>$request->quantity,
          'operationdetailes_id'=>$Operationdetailes->id,
          'price'=>$price,
          'opreationname'=>'لحام',
        ]);
        return redirect()->back();
    }
    public function deleteOrderDetailes($id){
          $Orderdetailes=Orderdetailes::with('operationdetailes')->find($id);
          $Operationdetailes=Operationdetailes::find($Orderdetailes->operationdetailes_id )->delete();
          $order=Order::find($Orderdetailes->order_id);
          $order->update([
            'quantity'=>$order->quantity-1,
         ]);
          Session::put('orderqnty',$order->quantity);
          return redirect()->back();
    }
}
