<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cuttingprice;

class cuttingController extends Controller
{
    //
    public function index(){
        $cuttingpanelsprices=cuttingprice::where('cuttingname_id',1)->get();
        $cuttingpulpsprices=cuttingprice::where('cuttingname_id',2)->get();
        $cuttingpeltsprices=cuttingprice::where('cuttingname_id',3)->get();
       // dd($cuttingprices);
        return view('Admin.cutting.index',compact('cuttingpanelsprices','cuttingpulpsprices','cuttingpeltsprices'));
    }
    public function  update(Request $request){
          // worning the id of cuttingprice table should start from 1 to 20
          if($request->type==1){
            foreach($request->price as $key=>$price){
                $cuttingprice= cuttingprice::where('cuttingname_id',1)->where('id',$key+1)->first();
                $cuttingprice->update([
                    'price'=>$price
                ]);
               }
          }elseif($request->type==2){
            foreach($request->price as $key=>$price){
                $cuttingprice= cuttingprice::where('cuttingname_id',2)->where('id',$key+8)->first();
                $cuttingprice->update([
                    'price'=>$price
                ]);
               }
          }elseif($request->type==3){
            foreach($request->price as $key=>$price){
                $cuttingprice= cuttingprice::where('cuttingname_id',3)->where('id',$key+9)->first();
                $cuttingprice->update([
                    'price'=>$price
                ]);
               }
          }

           return redirect()->back()->with('success','تم تحديث أسعار التقطيع بنجاح');
    }
}
