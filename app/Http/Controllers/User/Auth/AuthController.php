<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function login(){
        return view('User.Auth.login');
    }
    public function Submitlogin(Request $request){
    //    dd($request->all());
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            //dd('true');
            return view('User.home.index');
        }
        return redirect("/login")->with('error','Login details are not valid');
    }
}
