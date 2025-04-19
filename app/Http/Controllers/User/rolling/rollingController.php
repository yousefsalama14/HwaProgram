<?php

namespace App\Http\Controllers\User\rolling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rolleingname;
use App\Models\rolleingdetaile;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operationdetailes;
use Session;
use Auth;


class rollingController extends Controller
{
    //
    public function index(){
        $rolleingnames=rolleingname::get();
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',2);
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.rolling.index',compact('rolleingnames','order'));
    }
    #Reigon[rolling opreation]
        // this function sum the price of rolling
        function weight($thickness,$length,$width,$quntity){
            $weight=(7.85/10000)*($thickness*$length*$width);
            return $weight*$quntity;
        }
       public function weightCalc($num, $decimals) {
            return round($num * pow(10, $decimals)) / pow(10, $decimals);
    }
       function widthprice($rolling_id,$thickness,$length,$width,$quntity){
          $weight=$this->weight($thickness,$length,$width,$quntity);
          $rolleingname=rolleingname::find($rolling_id);
          if($weight<$rolleingname->smallweight){
            $price=$rolleingname->lesspriceweight;
        }else{
            $price=($rolleingname->price*$weight);
        }
        return $price;
       }
       public function rollingorder(Request $request){

            if($request->rollingname==1){
             $price= $this->widthprice(1,$request->thickness,$request->length,$request->width,$request->quantity);
             $opreationname='الدرفله فقط';
            }
            elseif($request->rollingname==2)
             {
                $price= $this->widthprice(2,$request->thickness,$request->length,$request->width,$request->quantity);
                $opreationname='الدرفله +لحام باصات';
            }
             else{
                $price=  $this->widthprice(3,$request->thickness,$request->length,$request->width,$request->quantity);
                $opreationname='الدرفله + لحام كامل';
            }
             $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
            // check if there are order or not if not order create new order
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
                'operation_id'=>2,
                'thickness'=>$request->thickness,
                'length'=>$request->length,
                'width'=>$request->width,
                'weight'=>$weight,
                'quantity'=>$request->quantity,  
            ]);
            $Orderdetailes=Orderdetailes::create([
                'order_id'=>$order->id,
                'operation_id'=>2,
                'quantity'=>$request->quantity,
                'operationdetailes_id'=>$Operationdetailes->id,
                'price'=>$price,
                'weight'=>$weight,
                'opreationname'=>$opreationname,
              ]);
              return redirect()->back();
       }
    #EndReigon
}
