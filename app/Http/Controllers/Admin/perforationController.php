<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\weldingwire;
use App\Models\perforationprice;
use App\Models\perforation_diameter_price;


class perforationController extends Controller
{
    //
    public function index(){
        $weldingwires=weldingwire::get();
        return view('Admin.perforation.index',compact('weldingwires'));
    }
    public function updatePrice(Request $request){

       // dd($request->all());
        $perforation=perforation_diameter_price::select('id')->where('perforation_id',$request->size)->where('diameter',$request->diameter)->first();
       $id=$perforation->id;
       $obj=perforation_diameter_price::find($id);
        if($obj!=null){
            $obj->update([
                'price'=>$request->price
             ]);
        }
        
        return redirect()->back();
    }

    public function getThickness(Request $request) {
        $size = perforationprice::select('value','name')->get();
        return $size;
    }

    public function getDiameter(Request $request) {
        $size = perforation_diameter_price::select('diameter')->where('perforation_id',$request->size)->get();
        return $size;
    }

    public function getPrice(Request $request) {
        $size = perforation_diameter_price::select('price')->where('perforation_id',$request->size)->where('diameter',$request->diameter)->get();
        return $size;
    }

    
}
