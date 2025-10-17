<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\weldingwire;


class weldingwireController extends Controller
{
    //
    public function index(){
        $weldingwires = weldingwire::get();
        return view('Admin.weldingwire.index',compact('weldingwires'));
    }
    public function update(Request $request){
        // Handle bulk update
        if ($request->has('price') && is_array($request->price)) {
            foreach ($request->price as $index => $price) {
                $id = $request->id[$index];
                $weldingwire = weldingwire::find($id);
                if ($weldingwire) {
                    $weldingwire->update([
                        'price' => $price
                    ]);
                }
            }
        } else {
            // Handle single update (fallback)
            $weldingwire = weldingwire::find($request->id);
            if ($weldingwire) {
                $weldingwire->update([
                    'price' => $request->price
                ]);
            }
        }

        return redirect()->back()->with('success', 'تم تحديث أسعار سلك اللحام بنجاح');
    }
}
