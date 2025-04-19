<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Foldprice;
class foldcontroller extends Controller
{
    //
    public function index(){
        $foldpanelsprices=Foldprice::where('foldname_id',1)->get();
        //dd($foldpanelsprices);
        // $cuttingpulpsprices=cuttingprice::where('cuttingname_id',2)->get();
        $foldpeltsprices=Foldprice::where('foldname_id',3)->get();
       // dd($cuttingprices);
        return view('Admin.fold.index',compact('foldpanelsprices','foldpeltsprices'));
    }
    public function update(Request $request){
        //dd($request->all());
        if($request->type==1){
            foreach($request->price as $key=>$price){
                $cuttingprice= Foldprice::where('foldname_id',1)->where('id',$key+1)->first();
                $cuttingprice->update([
                    'price'=>$price
                ]);
               }
          }elseif($request->type==3){
            foreach($request->price as $key=>$price){
                $cuttingprice= Foldprice::where('foldname_id',3)->where('id',$key+7)->first();
                $cuttingprice->update([
                    'price'=>$price
                ]);
               }
          }
          return redirect()->back();
    }
}
