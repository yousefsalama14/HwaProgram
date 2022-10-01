<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\weldingwire;


class weldingwireController extends Controller
{
    //
    public function index(){
        $weldingwires=weldingwire::get();
        return view('Admin.weldingwire.index',compact('weldingwires'));
    }
    public function update(Request $request){

       // dd($request->all());
        $weldingwire=weldingwire::find($request->id);
        $weldingwire->update([
           'price'=>$request->price
        ]);
        return redirect()->back();
    }
}
