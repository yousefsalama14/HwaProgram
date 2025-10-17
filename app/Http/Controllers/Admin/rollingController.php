<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rolleingname;
use App\Models\rolleingdetaile;

class rollingController extends Controller
{
    //
    public function index(){
        $rolleingnames=rolleingname::get();
         //dd($rolleingnames);
        return view('Admin.rolling.index',compact('rolleingnames'));
    }
    public function update(Request $request){

        $validated = $request->validate([
            'smallweight' => 'required',
            'lesspriceweight' => 'required',
            'price'=>'required'
        ]);
        $rolleingname=rolleingname::find($request->id);
        //dd( $rolleingdetailes->last());
        $rolleingname->update([
             'price'=>$request->price,
             'lesspriceweight'=>$request->lesspriceweight,
             'smallweight'=>$request->smallweight,
        ]);
       return redirect()->back()->with('success','تم تحديث بيانات الدرفلة بنجاح');
    }
}
