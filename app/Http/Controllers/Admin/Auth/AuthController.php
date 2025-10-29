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
        // If user is already authenticated, redirect to dashboard
        if (Auth::guard('Admin')->check()) {
            return redirect()->route('Admin.dashboard');
        }
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
            return redirect()->route('Admin.dashboard');
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
