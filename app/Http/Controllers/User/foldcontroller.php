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
            'price'=>$price,
            'opreationname'=>'تنايه الواح'
          ]);
          Alert::success('Success', 'تم اجاء العمليه بنجاح');
          return redirect()->back();
    }
}
