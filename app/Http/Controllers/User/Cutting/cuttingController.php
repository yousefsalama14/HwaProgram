<?php

namespace App\Http\Controllers\User\Cutting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cuttingprice;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operationdetailes;
use Auth;

class cuttingController extends Controller
{
    //
    public function indexboards(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',3);
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.cutting.cuttingboard',compact('order'));
    }
    function weight($thickness,$length,$width){
        $weight=(7.85/10000)*($thickness*$length*$width);
        return $weight;
    }
    public function cuttingboardorder(Request $request){
        $request->validate([
            'length'=>'required',
            'weidth'=>'required',
            'thickness'=>'required',
        ]);
         $length=$request->length;
         $weight=$this->weight($request->thickness,$request->length,$request->width);
         if($length==1||$length==2||$length==3||$length==4||$length==5||$length==6||$length==7||$length==9){
           $price=cuttingprice::where('value',$length)->first();
           $price=$price->price*$request->quantity*$request->cuttingqnty;
         }
         elseif($length==10||$length==11||$length==12){
            $price=cuttingprice::where('value',10)->first();
            $price=$price->price*$request->quantity*$request->cuttingqnty;
         }else{
            return redirect()->back();
         }
         $order=Order::with('orderdetailes')->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
         if($order==null){
              $order=Order::create([
                  'status'=>'unpaid',
                  'user_id'=>Auth::user()->id
               ]);
          }
          $Operationdetailes=Operationdetailes::create([
            'operation_id'=>3,
            'thickness'=>$request->thickness,
            'length'=>$request->length,
            'width'=>$request->width,
            'weight'=>$weight,
            'quantity'=>$request->quantity,
            'cuttingqnty'=>$request->cuttingqnty,

        ]);
        $Orderdetailes=Orderdetailes::create([
            'order_id'=>$order->id,
            'operation_id'=>3,
            'quantity'=>$request->quantity,
            'operationdetailes_id'=>$Operationdetailes->id,
            'price'=>$price,
            'opreationname'=>'تقطيع الواح'
          ]);
          return redirect()->back();
    }
    public function indexbulbs(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',3);
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.cutting.cuttingbulbs',compact('order'));
    }
    public function cuttingbulbsorder(Request $request){
        $request->validate([
            'length'=>'required',
            'weidth'=>'required',
            'thickness'=>'required',
            'cuttinglength'=>'required',
        ]);
       $length=$request->length;
       $weight=$this->weight($request->thickness,$request->length,$request->width);
       $cuttinglength=$request->cuttinglength;
       if($length>=13 && $length<=15){
          $time=$cuttinglength/1.5;
       }elseif($length>=16 && $length<=17){
        $time=$cuttinglength*2;
       }elseif($length>=18 && $length<=20){
        $time=$cuttinglength*3;
       }
       elseif($length>=21 && $length<=25){
        $time=$cuttinglength*3.5;
       } elseif($length>=26 && $length<=30){
        $time=$cuttinglength*4.5;
        }else{
            return redirect()->back();
        }
        $cuttingprice=cuttingprice::find(7);
        $price=$cuttingprice->price*$time*$request->quantity;
        $order=Order::with('orderdetailes')->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        if($order==null){
             $order=Order::create([
                 'status'=>'unpaid',
                 'user_id'=>Auth::user()->id
              ]);
         }
         $Operationdetailes=Operationdetailes::create([
           'operation_id'=>3,
           'thickness'=>$request->thickness,
           'length'=>$request->length,
           'width'=>$request->width,
           'weight'=>$weight,
           'quantity'=>$request->quantity,
           'cuttingqnty'=>$request->cuttingqnty,

       ]);
       $Orderdetailes=Orderdetailes::create([
           'order_id'=>$order->id,
           'operation_id'=>3,
           'quantity'=>$request->quantity,
           'operationdetailes_id'=>$Operationdetailes->id,
           'price'=>$price,
           'opreationname'=>'تقطيع لمبه'
         ]);
         return redirect()->back();
    }
    public function indexpallet(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',3);
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.cutting.cuttingpallets',compact('order'));
    }
    public function cuttingpallet(Request $request){
     //   dd($request->all());
        $request->validate([
            'length'=>'required',
            'weidth'=>'required',
            'thickness'=>'required',
            'quantity'=>'required',
        ]);
        $weight=$this->weight($request->thickness,$request->length,$request->width);
        $circumference =($request->length+$request->weidth)*2;
        if($request->thickness<1){
            $cuttingprice=cuttingprice::find(8);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=1&&$request->thickness<=2){
            $cuttingprice=cuttingprice::find(9);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=2&&$request->thickness<=3){
            $cuttingprice=cuttingprice::find(10);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=3&&$request->thickness<=4){
            $cuttingprice=cuttingprice::find(11);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=4&&$request->thickness<=5){
            $cuttingprice=cuttingprice::find(12);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=5&&$request->thickness<=6){
            $cuttingprice=cuttingprice::find(13);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=6&&$request->thickness<=7){
            $cuttingprice=cuttingprice::find(14);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=7&&$request->thickness<=8){
            $cuttingprice=cuttingprice::find(15);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=8&&$request->thickness<=9){
            $cuttingprice=cuttingprice::find(16);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=9&&$request->thickness<=10){
            $cuttingprice=cuttingprice::find(17);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness>=10&&$request->thickness<=11){
            $cuttingprice=cuttingprice::find(18);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness>=11&&$request->thickness<=12){
            $cuttingprice=cuttingprice::find(19);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness==12){
            $cuttingprice=cuttingprice::find(20);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }

        $order=Order::with('orderdetailes')->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        if($order==null){
             $order=Order::create([
                 'status'=>'unpaid',
                 'user_id'=>Auth::user()->id
              ]);
         }
         $Operationdetailes=Operationdetailes::create([
           'operation_id'=>3,
           'thickness'=>$request->thickness,
           'length'=>$request->length,
           'width'=>$request->width,
           'weight'=>$weight,
           'quantity'=>$request->quantity,
           'cuttingqnty'=>$request->cuttingqnty,

       ]);
       $Orderdetailes=Orderdetailes::create([
           'order_id'=>$order->id,
           'operation_id'=>3,
           'quantity'=>$request->quantity,
           'operationdetailes_id'=>$Operationdetailes->id,
           'price'=>$price,
           'opreationname'=>'تقطيع بلتات'
         ]);
         return redirect()->back();
    }
}
