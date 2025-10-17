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
    function weight($thickness,$length,$width,$qty){
        $weight=(7.85/10000)*($thickness*$length*$width);
        return $weight*$qty;
    }
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
            'total_length' =>'required'
        ]);
        // if($request->thickness>12){
        //   return redirect()->back();
        // }
        if($request->thickness<=2 && $request->thickness > 0){
                // if thickness <=5 use weilding wire 2.5
                 $weldingwire=weldingwire::find(1);
                if($request->thickness<=2 && $request->thickness>0){
                     $amount=$request->total_length/(25);
                }
                // else if($request->thickness>=2 && $request->thickness<=4){
                //     $amount=$request->total_length/(20);
                // }
                // else if($request->thickness<=5){
                //     $amount=$request->total_length/(17);
                // }
                // error_log('ammount='.$amount.'price'.$weldingwire->price.'passes'.$request->passes.'qty'.$request->quantity);
               $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        }else if($request->thickness>2 && $request->thickness<=8){

                 $weldingwire=weldingwire::find(2);
                 if($request->thickness>=2 && $request->thickness<=4){
                    $amount=$request->total_length/(20);
                }
                else if($request->thickness<=5){
                    $amount=$request->total_length/(17);
                }
                 else if($request->thickness<=6){
                    $amount=$request->total_length/(15);
                  }
                  else if($request->thickness<=7){
                    $amount=$request->total_length/(14);
                 }
                else if($request->thickness<=8){
                    $amount=$request->total_length/(12);
                }
                $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        }else if($request->thickness>8 && $request->thickness<=12){
                $weldingwire=weldingwire::find(3);
                if($request->thickness<=9){
                    $amount=$request->total_length/(11);
                }
                else if($request->thickness<=10){
                    $amount=$request->total_length/(10);
                }
                else if($request->thickness<=11){
                    $amount=$request->total_length/(9);
                }
                else if($request->thickness<=12){
                    $amount=$request->total_length/(8);
                }
                $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        }else if($request->thickness > 12){
            $weldingwire=weldingwire::find(4);
            $amount=$request->total_length/100;
            $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        }
        error_log('ammount='.$amount.'price'.$weldingwire->price.'passes'.$request->passes.'qty'.$request->quantity);
        $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
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
            'length'=>$request->total_length,
            'passes'=>$request->passes,
            'quantity'=>$request->quantity,
            'width'=>$request->width,
            'total_length'=>$request->length
        ]);
        $Orderdetailes=Orderdetailes::create([
          'order_id'=>$order->id,
          'operation_id'=>1,
          'quantity'=>$request->quantity,
          'operationdetailes_id'=>$Operationdetailes->id,
          'price'=>$price,
          'weight'=>$weight,
          'opreationname'=>'لحام',
        ]);
        return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');
    }
    public function deleteOrderDetailes($id){
          $Orderdetailes=Orderdetailes::with('operationdetailes')->find($id);
          $Operationdetailes=Operationdetailes::find($Orderdetailes->operationdetailes_id)->delete();
          $order=Order::find($Orderdetailes->order_id);
          $order->update([
            'quantity'=>$order->quantity-1,
         ]);
          Session::put('orderqnty',$order->quantity);
          return redirect()->back();
    }
}
