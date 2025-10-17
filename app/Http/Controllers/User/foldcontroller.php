<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Foldprice;
use App\Models\fold_length_price;
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
    function weight($thickness,$length,$width,$qty){
        $weight=(7.85/10000)*($thickness*$length*$width);
        return $weight*$qty;
    }
    function weightWithoutQty($thickness,$length,$width){
        $weight=(7.85/10000)*($thickness*($length*100)*$width);
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
         $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
         if($thickness>=1 && $thickness<=9){
           $price=Foldprice::where('value',round($thickness))->first();
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
          return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');
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
            'quantity'=>'required',

        ]);
        $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
       // $circumference =($request->length+$request->width)*2;

        if($request->thickness<=1){
            $foldingprice1=fold_length_price::where('length',ceil  ($request->length1/100))->where('fold_id','11')->get();;
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','11')->get();;
            $foldingprice3=fold_length_price::where('length',ceil  ($request->length3/100))->where('fold_id','11')->get();;
            $foldingprice4=fold_length_price::where('length',ceil  ($request->length4/100))->where('fold_id','11')->get();;
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }else if($request->thickness>=1&&$request->thickness<=2){
            $foldingprice1=fold_length_price::where('length',ceil ($request->length1/100))->where('fold_id','12')->get();
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','12')->get();
            $foldingprice3=fold_length_price::where('length',ceil ($request->length3/100))->where('fold_id','12')->get();
            $foldingprice4=fold_length_price::where('length',ceil ($request->length4/100))->where('fold_id','12')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }else if($request->thickness>=2&&$request->thickness<=3){
            $foldingprice1=fold_length_price::where('length',ceil ($request->length1/100))->where('fold_id','13')->get();
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','13')->get();
            $foldingprice3=fold_length_price::where('length',ceil ($request->length3/100))->where('fold_id','13')->get();
            $foldingprice4=fold_length_price::where('length',ceil ($request->length4/100))->where('fold_id','13')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }else if($request->thickness>=3&&$request->thickness<=4){
            $foldingprice1=fold_length_price::where('length', ceil  ($request->length1/100))->where('fold_id','14')->get();
            $foldingprice2=fold_length_price::where('length', ceil  ($request->length2/100))->where('fold_id','14')->get();
            $foldingprice3=fold_length_price::where('length', ceil  ($request->length3/100))->where('fold_id','14')->get();
            $foldingprice4=fold_length_price::where('length', ceil  ($request->length4/100))->where('fold_id','14')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }elseif($request->thickness>=4&&$request->thickness<=5){
            $foldingprice1=fold_length_price::where('length',ceil ($request->length1/100))->where('fold_id','15')->get();
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','15')->get();;
            $foldingprice3=fold_length_price::where('length',ceil ($request->length3/100))->where('fold_id','15')->get();;
            $foldingprice4=fold_length_price::where('length',ceil ($request->length4/100))->where('fold_id','15')->get();;
            error_log(ceil ($request->length1/100));
            error_log($foldingprice1);

            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;

        }else if($request->thickness>=5&&$request->thickness<=6){
            $foldingprice1=fold_length_price::where('length',ceil ($request->length1/100))->where('fold_id','16')->get();
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','16')->get();
            $foldingprice3=fold_length_price::where('length',ceil ($request->length3/100))->where('fold_id','16')->get();
            $foldingprice4=fold_length_price::where('length',ceil ($request->length4/100))->where('fold_id','16')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }elseif($request->thickness>=6&&$request->thickness<=7){
            $foldingprice1=fold_length_price::where('length',ceil ($request->length1/100))->where('fold_id','17')->get();
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','17')->get();
            $foldingprice3=fold_length_price::where('length',ceil  ($request->length3/100))->where('fold_id','17')->get();
            $foldingprice4=fold_length_price::where('length',ceil  ($request->length4/100))->where('fold_id','17')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }
        elseif($request->thickness>=7&&$request->thickness<=8){
            $foldingprice1=fold_length_price::where('length',ceil ($request->length1/100))->where('fold_id','18')->get();
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','18')->get();
            $foldingprice3=fold_length_price::where('length',ceil ($request->length3/100))->where('fold_id','18')->get();
            $foldingprice4=fold_length_price::where('length',ceil ($request->length4/100))->where('fold_id','18')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }
        elseif($request->thickness>=8&&$request->thickness<=9){
            $foldingprice1=fold_length_price::where('length',ceil  ($request->length1/100))->where('fold_id','19')->get();
            $foldingprice2=fold_length_price::where('length',ceil  ($request->length2/100))->where('fold_id','19')->get();
            $foldingprice3=fold_length_price::where('length',ceil  ($request->length3/100))->where('fold_id','19')->get();
            $foldingprice4=fold_length_price::where('length',ceil  ($request->length4/100))->where('fold_id','19')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }
        elseif($request->thickness>=9&&$request->thickness<=10){
            $foldingprice1=fold_length_price::where('length',ceil ($request->length1/100))->where('fold_id','20')->get();
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','20')->get();
            $foldingprice3=fold_length_price::where('length',ceil ($request->length3/100))->where('fold_id','20')->get();
            $foldingprice4=fold_length_price::where('length',ceil ($request->length4/100))->where('fold_id','20')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }  elseif($request->thickness>=10&&$request->thickness<=11){
            $foldingprice1=fold_length_price::where('length',ceil ($request->length1/100))->where('fold_id','21')->get();;
            $foldingprice2=fold_length_price::where('length',ceil ($request->length2/100))->where('fold_id','21')->get();;
            $foldingprice3=fold_length_price::where('length',ceil ($request->length3/100))->where('fold_id','21')->get();;
            $foldingprice4=fold_length_price::where('length',ceil ($request->length4/100))->where('fold_id','21')->get();;
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && $foldingprice1[0]->price!=null){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && $foldingprice2[0]->price!=null){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && $foldingprice3[0]->price!=null){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && $foldingprice4[0]->price!=null){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }  elseif($request->thickness>=11&&$request->thickness<=12){
            $foldingprice1=fold_length_price::where('length',ceil  ($request->length1/100))->where('fold_id','22')->get();
            $foldingprice2=fold_length_price::where('length',ceil  ($request->length2/100))->where('fold_id','22')->get();
            $foldingprice3=fold_length_price::where('length',ceil  ($request->length3/100))->where('fold_id','22')->get();
            $foldingprice4=fold_length_price::where('length',ceil  ($request->length4/100))->where('fold_id','22')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }  elseif($request->thickness==12){
            $foldingprice1=fold_length_price::where('length',ceil  ($request->length1/100))->where('fold_id','23')->get();
            $foldingprice2=fold_length_price::where('length',ceil  ($request->length2/100))->where('fold_id','23')->get();
            $foldingprice3=fold_length_price::where('length',ceil  ($request->length3/100))->where('fold_id','23')->get();
            $foldingprice4=fold_length_price::where('length',ceil  ($request->length4/100))->where('fold_id','23')->get();
            $price=0;
            if($foldingprice1!=null && $request->count1!=null && count($foldingprice1)>0){
                $price=$price+ $foldingprice1[0]->price*$request->count1;
            }
            if($foldingprice2!=null && $request->count2!=null && count($foldingprice2)>0){
                $price=$price+ $foldingprice2[0]->price*$request->count2;
            }

            if($foldingprice3!=null && $request->count3!=null && count($foldingprice3)>0){
                $price=$price+ $foldingprice3[0]->price*$request->count3;
            }

            if($foldingprice4!=null && $request->count4!=null && count($foldingprice4)>0){
                $price=$price+ $foldingprice4[0]->price*$request->count4;
            }
            $price=$price * $request->quantity;
        }else{
            dd('gfgf');
        }

        if($price>0){
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
                return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');
        }else{
            return redirect()->back();
        }



            }



            public function indexornaments(){
                $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
                    $q->where('operation_id','=',4)->where('opreationname','مجرة المطر المجلفنة');
                }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();


                $orderother=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
                    $q->where('operation_id','=',4)->where('opreationname','حليات الايكون');
                }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
               // dd($order);
                return view('User.follding.foldornaments',compact('order','orderother'));
            }


           public function foldingornamentsorder(Request $request){
            //  dd($request->all());
               $foldprice= Foldprice::where('foldname_id',2)->where('id',24)->first();
               $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
               $foldprice=($foldprice->price);
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
                  'quantity'=>$request->quantity,
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
                return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');
           }


    public function foldingotherornamentsorder(Request $request){
    // dd($request->all());
    $foldprice= Foldprice::where('foldname_id',4)->where('id',25)->first();
    $price=$foldprice->price*$request->foldLength*$request->foldQnty;
    $order=Order::with('orderdetailes')->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
    $foldWeight=$this->weightWithoutQty($request->foldThickness,$request->foldLength,$request->foldWidth);
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
        'length'=>$request->foldLength,
        'foldqnty'=>$request->foldQnty,
        'thickness'=>$request->foldThickness,
        'width'=>$request->foldWidth,
        'weight'=>$foldWeight,
        ]);
    $Orderdetailes=Orderdetailes::create([
    'order_id'=>$order->id,
    'operation_id'=>4,
    'quantity'=>$request->foldQnty,
    'operationdetailes_id'=>$Operationdetailes->id,
    'price'=>$price,
    'opreationname'=>'حليات الايكون',
    'weight'=>$foldWeight,
    ]);
    return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح');

    }

 }

