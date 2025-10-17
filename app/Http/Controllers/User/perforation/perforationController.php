<?php

namespace App\Http\Controllers\User\perforation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\weldingwire;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operation;
use App\Models\Operationdetailes;
use App\Models\perforationprice;
use App\Models\perforation_diameter_price;
use App\Http\Controllers\User\Cart\CartController;
use Auth;
use Session;
class perforationController extends Controller
{
    //
    function weight($thickness,$length,$width,$qty){
        $weight=(7.85/10000)*($thickness*$length*$width);
        return $weight*$qty;
    }
    public function index(){
        $order=Order::with(['orderdetailes.operationdetailes','orderdetailes'=>function($q){
            $q->where('operation_id','=',6);
        }])->where('user_id',Auth::user()->id)->where('status','=','unpaid')->first();
        return view('User.perforation.index',compact('order'));
    }
    public function perforationorder(Request $request){
        $validated = $request->validate([
            'thickness' => 'required|numeric',
            'length' => 'required',
            'punchDiameter' => 'required|exists:perforation_diameter_prices,diameter',
            'quantity' => 'required',
            'perforationCount' =>'required'
        ]);

        if($request->thickness!=null && $request->punchDiameter!=null){
            $thikId=0;
            if($request->thickness >=.22 && $request->thickness <=4){
                $thikId=1;
            }else if($request->thickness >=4.1 && $request->thickness <=6){
                $thikId=2;
            }else if($request->thickness >=6.1 && $request->thickness <=8){
                $thikId=3;
            }else if($request->thickness >=8.1 && $request->thickness <=10){
                $thikId=4;
            }else if($request->thickness >=10.1 && $request->thickness <=12){
                $thikId=5;
            }else if($request->thickness >=12.1 && $request->thickness <=15){
                $thikId=6;
            }else if($request->thickness >=15.1 && $request->thickness <=20){
                $thikId=7;
            }else if($request->thickness >=20.1 && $request->thickness <=22){
                $thikId=8;
            }else if($request->thickness >=22.1 && $request->thickness <=25){
                $thikId=9;
            }else if($request->thickness >=25.1 && $request->thickness <=30){
                $thikId=10;
            }else if($request->thickness >=30.1 && $request->thickness <=35){
                $thikId=11;
            }else if($request->thickness >35 ){
                $thikId=12;
            }
            $obj = perforation_diameter_price::where('perforation_id', $thikId)
                                            ->where('diameter', $request->punchDiameter)
                                            ->first();

            if (!$obj) {
                \Log::error('No price found for:', [
                    'thickness_id' => $thikId,
                    'diameter' => $request->punchDiameter,
                    'original_thickness' => $request->thickness
                ]);
                return redirect()->back()
                    ->with('error', 'لا يوجد سعر محدد لهذا السمك وقطر البنطة');
            }

            // Only proceed if we found a valid price
            error_log('price=' . $obj->price);
            $price = $obj->price * $request->perforationCount * $request->quantity;
        }
        //     if($request->thickness<=2 && $request->thickness > 0){
        //             // if thickness <=5 use weilding wire 2.5
        //              $weldingwire=weldingwire::find(1);
        //             if($request->thickness<=2 && $request->thickness>0){
        //                  $amount=$request->total_length/(25);
        //             }
        //             // error_log('ammount='.$amount.'price'.$weldingwire->price.'passes'.$request->passes.'qty'.$request->quantity);
        //            $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        //     }else if($request->thickness>2 && $request->thickness<=8){

        //              $weldingwire=weldingwire::find(2);
        //              if($request->thickness>=2 && $request->thickness<=4){
        //                 $amount=$request->total_length/(20);
        //             }
        //             else if($request->thickness<=5){
        //                 $amount=$request->total_length/(17);
        //             }
        //              else if($request->thickness<=6){
        //                 $amount=$request->total_length/(15);
        //               }
        //               else if($request->thickness<=7){
        //                 $amount=$request->total_length/(14);
        //              }
        //             else if($request->thickness<=8){
        //                 $amount=$request->total_length/(12);
        //             }
        //             $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        //     }else if($request->thickness>8 && $request->thickness<=12){
        //             $weldingwire=weldingwire::find(3);
        //             if($request->thickness<=9){
        //                 $amount=$request->total_length/(11);
        //             }
        //             else if($request->thickness<=10){
        //                 $amount=$request->total_length/(10);
        //             }
        //             else if($request->thickness<=11){
        //                 $amount=$request->total_length/(9);
        //             }
        //             else if($request->thickness<=12){
        //                 $amount=$request->total_length/(8);
        //             }
        //             $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        //     }else if($request->thickness > 12){
        //         $weldingwire=weldingwire::find(4);
        //         $amount=$request->total_length/100;
        //         $price=(($amount*$weldingwire->price)*$request->passes)*$request->quantity;
        //     }
        //     error_log('ammount='.$amount.'price'.$weldingwire->price.'passes'.$request->passes.'qty'.$request->quantity);
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
      $order->load('orderdetailes');
      Session::put('orderqnty', CartController::getGroupedCartCount($order));
        $Operationdetailes=Operationdetailes::create([
            'operation_id'=>6,
            'thickness'=>$request->thickness,
            'length'=>$request->length,
            'quantity'=>$request->quantity,
            'width'=>$request->width,
            'total_length'=>$request->length,
            'perforationCount' => $request->perforationCount,
            'punchDiameter' => $request->punchDiameter,
        ]);
        $Orderdetailes=Orderdetailes::create([
          'order_id'=>$order->id,
          'operation_id'=>6,
          'quantity'=>$request->quantity,
          'operationdetailes_id'=>$Operationdetailes->id,
          'price'=>$price,
          'weight'=>$weight,
          'opreationname'=>'تخريم',
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
          $order->load('orderdetailes');
          Session::put('orderqnty', $order->orderdetailes->count());
          return redirect()->back();
    }
}
