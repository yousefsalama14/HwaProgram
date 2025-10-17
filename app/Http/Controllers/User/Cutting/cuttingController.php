<?php

namespace App\Http\Controllers\User\Cutting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cuttingprice;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operationdetailes;
use Auth;
use Session;
use Alert;
class cuttingController extends Controller
{
    //
    public function indexboards(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',3)->where('opreationname','تقطيع الواح');
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.cutting.cuttingboard',compact('order'));
    }
    function weight($thickness,$length,$width,$quntity){
        $weight=(7.85/10000)*($thickness*$length*$width);
        return $weight*$quntity;
    }
    public function cuttingboardorder(Request $request){
        $request->validate([
            'length'=>'required',
            'width'=>'required',
            'thickness'=>'required',
        ]);
         $thickness=$request->thickness;
         $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
         if($thickness>=4 && $thickness<10){
            $thickness=round($thickness,0,PHP_ROUND_HALF_UP);
           $price=cuttingprice::where('value',$thickness)->first();
           $price=$price->price*$request->quantity*$request->cuttingqnty;
         }
         elseif($thickness>=10 && $thickness<13){
            $price=cuttingprice::where('value',10)->first();
            $price=$price->price*$request->quantity*$request->cuttingqnty;
         }else{
            return redirect()->back();
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
            'weight'=>$weight,
            'opreationname'=>'تقطيع الواح'
          ]);
          return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');
    }
    public function indexbulbs(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',3)->where('opreationname','تقطيع لمبه');
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.cutting.cuttingbulbs',compact('order'));
    }
    public function cuttingbulbsorder(Request $request){
        $request->validate([
            'length'=>'required',
            'width'=>'required',
            'thickness'=>'required',
            'cuttinglength'=>'required',
            'quantity'=>'required'
        ]);
       $thickness=$request->thickness;
       $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
       $cuttinglength=$request->cuttinglength/100;
       if($thickness>=12 && $thickness<15){
          $time=$cuttinglength*1.5;
       }elseif($thickness>=15 && $thickness<17){
        $time=$cuttinglength*2;
       }elseif($thickness>=17 && $thickness<20){
        $time=$cuttinglength*3;
       }
       elseif($thickness>=20 && $thickness<25){
        $time=$cuttinglength*3.5;
       } elseif($thickness>=25 && $thickness<30){
        $time=$cuttinglength*4.5;
        }elseif($thickness>=30){
            $time=$cuttinglength*6;
            }
        else{
            return redirect()->back();
        }
        $cuttingprice=cuttingprice::find(8);
        $price=$cuttingprice->price*$time*$request->quantity;
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
           'weight'=>$weight,
           'opreationname'=>'تقطيع لمبه',
           'weight'=> $weight
         ]);
         return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');
    }
    public function indexpallet(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',3)->where('opreationname','تقطيع بلتات');
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.cutting.cuttingpallets',compact('order'));
    }
    public function cuttingpallet(Request $request){
     //   dd($request->all());
        $request->validate([
            'length'=>'required',
            'width'=>'required',
            'thickness'=>'required',
            'quantity'=>'required',
        ]);
        $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
        // $weight=$weight*$request->quantity;
        $circumference =($request->length+$request->width)*2;
        $circumference =$circumference /100;
        if($request->thickness<1){
            $cuttingprice=cuttingprice::find(9);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=1&&$request->thickness<=2){
            $cuttingprice=cuttingprice::find(10);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=2&&$request->thickness<=3){
            $cuttingprice=cuttingprice::find(11);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=3&&$request->thickness<=4){
            $cuttingprice=cuttingprice::find(12);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=4&&$request->thickness<=5){
            $cuttingprice=cuttingprice::find(13);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=5&&$request->thickness<=6){
            $cuttingprice=cuttingprice::find(14);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=6&&$request->thickness<=7){
            $cuttingprice=cuttingprice::find(15);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=7&&$request->thickness<=8){
            $cuttingprice=cuttingprice::find(16);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=8&&$request->thickness<=9){
            $cuttingprice=cuttingprice::find(17);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=9&&$request->thickness<=10){
            $cuttingprice=cuttingprice::find(18);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness>=10&&$request->thickness<=11){
            $cuttingprice=cuttingprice::find(19);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness>=11&&$request->thickness<12){
            $cuttingprice=cuttingprice::find(20);
            $price=$cuttingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness==12){
            $cuttingprice=cuttingprice::find(21);
            $price=$cuttingprice->price*$circumference*$request->quantity;
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
           'weight'=>$weight,
           'opreationname'=>'تقطيع بلتات'
         ]);
         return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');
    }
}
