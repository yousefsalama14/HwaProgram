<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Foldprice;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operationdetailes;
use Auth;
use Session;
use Alert;
class foldcontroller extends Controller
{
    //
    public function indexboards(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',4)->where('opreationname','تنايه الواح');
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.follding.folldingboard',compact('order'));
    }
    function weight($thickness,$length,$width){
        $weight=(7.85/10000)*($thickness*$length*$width);
        return $weight;
    }
    public function foldingboardorder(Request $request){
        //dd($request->all());
        $request->validate([
            'length'=>'required',
            'width'=>'required',
            'thickness'=>'required',
        ]);
         $thickness=$request->thickness;
         $weight=$this->weight($request->thickness,$request->length,$request->width);
         if($thickness==1||$thickness==2||$thickness==3||$thickness==4||$thickness==5||$thickness==6||$thickness==7||$thickness==9){
           $price=Foldprice::where('value',$thickness)->first();
           $price=$price->price*$request->quantity*$request->foldqnty;
         }
         elseif($thickness==10||$thickness==11||$thickness==12){
            $price=Foldprice::where('value',10)->first();
            $price=$price->price*$request->quantity*$request->foldqnty;

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
            'operation_id'=>4,
            'thickness'=>$request->thickness,
            'length'=>$request->length,
            'width'=>$request->width,
            'weight'=>$weight,
            'quantity'=>$request->quantity,
            'foldqnty'=>$request->foldqnty,

        ]);
        $Orderdetailes=Orderdetailes::create([
            'order_id'=>$order->id,
            'operation_id'=>4,
            'quantity'=>$request->quantity,
            'operationdetailes_id'=>$Operationdetailes->id,
            'weight'=>$weight,
            'price'=>$price,
            'opreationname'=>'تنايه الواح'
          ]);
          Alert::success('Success', 'تم اجاء العمليه بنجاح');
          return redirect()->back();
    }


    public function indexpallet(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',4)->where('opreationname','تنايه بلتات');
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
       // dd($order);
        return view('User.follding.foldingpallets',compact('order'));
    }
    public function foldingpalletorder(Request $request){
       // dd($request->all());
        $request->validate([
            'length'=>'required',
            'width'=>'required',
            'thickness'=>'required',
            'quantity'=>'required'
        ]);
        $weight=$this->weight($request->thickness,$request->length,$request->width);
        $circumference =($request->length+$request->width)*2;

        if($request->thickness<1){
            $foldingprice=Foldprice::find(7);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=1&&$request->thickness<=2){
            ///dd(55);
            $foldingprice=Foldprice::find(8);
            $price=$foldingprice->price*$circumference*$request->quantity;
            //dd($price);
        }elseif($request->thickness>=2&&$request->thickness<=3){
            $foldingprice=Foldprice::find(9);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=3&&$request->thickness<=4){
            $foldingprice=Foldprice::find(10);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=4&&$request->thickness<=5){
            $foldingprice=Foldprice::find(11);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=5&&$request->thickness<=6){
            $foldingprice=Foldprice::find(12);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }elseif($request->thickness>=6&&$request->thickness<=7){
            $foldingprice=Foldprice::find(13);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=7&&$request->thickness<=8){
            $foldingprice=Foldprice::find(14);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=8&&$request->thickness<=9){
            $foldingprice=Foldprice::find(15);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }
        elseif($request->thickness>=9&&$request->thickness<=10){
            $foldingprice=Foldprice::find(16);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness>=10&&$request->thickness<=11){
            $foldingprice=Foldprice::find(17);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness>=11&&$request->thickness<=12){
            $foldingprice=Foldprice::find(18);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }  elseif($request->thickness==12){
            $foldingprice=Foldprice::find(19);
            $price=$foldingprice->price*$circumference*$request->quantity;
        }else{
            dd('gfgf');
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
           'operation_id'=>4,
           'thickness'=>$request->thickness,
           'length'=>$request->length,
           'width'=>$request->width,
           'weight'=>$weight,
           'quantity'=>$request->quantity,
           'cuttingqnty'=>$request->cuttingqnty,
           'foldqnty'=>$request->foldqnty,

          ]);
              $Orderdetailes=Orderdetailes::create([
                'order_id'=>$order->id,
                'operation_id'=>4,
                'quantity'=>$request->quantity,
                'operationdetailes_id'=>$Operationdetailes->id,
                'weight'=>$weight,
                'price'=>$price,
                'opreationname'=>'تنايه بلتات'
                ]);
                Alert::success('Success Title', 'تم اجاء العمليه بنجاح');
                return redirect()->back();


            }



            public function indexornaments(){
                $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
                    $q->where('operation_id','=',4)->where('opreationname','مجرة المطر المجلفنة');
                }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();


                $orderother=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
                    $q->where('operation_id','=',4)->where('opreationname','الحليات الأخري');
                }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
               // dd($order);
                return view('User.follding.foldornaments',compact('order','orderother'));
            }


           public function foldingornamentsorder(Request $request){
            //  dd($request->all());
               $foldprice= Foldprice::where('foldname_id',2)->where('id',21)->first();
               $weight=$this->weight($request->thickness,$request->length,$request->width);
               $foldprice=($foldprice->price+1000)/1000;
               $price=$foldprice*$weight;
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
                  'operation_id'=>4,
                  'thickness'=>$request->thickness,
                  'length'=>$request->length,
                  'width'=>$request->width,
                  'weight'=>$weight,
                  'foldqnty'=>$request->foldqnty,
                 ]);
                $Orderdetailes=Orderdetailes::create([
                'order_id'=>$order->id,
                'operation_id'=>4,
                'quantity'=>$request->quantity,
                'operationdetailes_id'=>$Operationdetailes->id,
                'weight'=>$weight,
                'price'=>$price,
                'opreationname'=>'مجرة المطر المجلفنة'
                ]);
                Alert::success('Success Title', 'تم اجاء العمليه بنجاح');
                return redirect()->back();
           }


           public function foldingotherornamentsorder(Request $request){
           // dd($request->all());
            $foldprice= Foldprice::where('foldname_id',4)->where('id',22)->first();
           $price=$foldprice->price*$request->foldqnty*$request->length*$request->quantity;
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
              'operation_id'=>4,
              'length'=>$request->length,
              'foldqnty'=>$request->foldqnty,
             ]);
            $Orderdetailes=Orderdetailes::create([
            'order_id'=>$order->id,
            'operation_id'=>4,
            'quantity'=>$request->foldqnty,
            'operationdetailes_id'=>$Operationdetailes->id,
            'price'=>$price,
            'opreationname'=>'الحليات الأخري'
            ]);
            Alert::success('Success Title', 'تم اجاء العمليه بنجاح');
            return redirect()->back();

           }

 }

