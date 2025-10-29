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
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['redirect' => route('Admin.dashboard')]);
            }
            return redirect()->route('Admin.dashboard');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'بيانات تسجيل الدخول غير صحيحة'], 401);
        }

        return back()->with('error', 'بيانات تسجيل الدخول غير صحيحة')->withInput();
    }

    public function logout()
    {
        Session::flush();
        Auth::guard('Admin')->logout();
        return redirect()->route('adminLogin');
    }
}
