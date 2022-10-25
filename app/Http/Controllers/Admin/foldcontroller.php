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

        $foldheliatsprices=Foldprice::where('foldname_id',2)->get();
        $foldheliatothersprices=Foldprice::where('foldname_id',4)->get();
       // dd($cuttingprices);
        return view('Admin.Fold.index',compact('foldpanelsprices','foldpeltsprices','foldheliatsprices','foldheliatothersprices'));
    }
    public function update(Request $request){
       // dd($request->all());
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
          }elseif($request->type==2){
            $cuttingprice= Foldprice::where('foldname_id',2)->where('id',21)->first()->update([
                'price'=>$request->tan
            ]);
            $cuttingprice= Foldprice::where('foldname_id',4)->where('id',22)->first()->update([
                'price'=>$request->meter
            ]);;
          }
          return redirect()->back();
    }
}
