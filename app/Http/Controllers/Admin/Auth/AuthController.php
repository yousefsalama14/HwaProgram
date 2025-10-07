<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
    //
    public function login(){
        return view('Admin.Auth.login');
    }
    public function Submitlogin(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('Admin')->attempt($credentials)) {
            //dd('true');
            return view('Admin.dashboard.index');
        }
        return redirect()->route('adminLogin')->with('error','Login details are not valid');
    }

    public function logout()
    {
        Session::flush();
        Auth::guard('Admin')->logout();
        return redirect()->route('adminLogin');
    }
}
