<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function login()
    {
        // If user is already authenticated, redirect to home
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.home');
        }
        return view('User.Auth.login');
    }
    public function Submitlogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['redirect' => route('user.home')]);
            }
            return redirect()->route('user.home');
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'بيانات تسجيل الدخول غير صحيحة'], 401);
        }
        return back()->with('error', 'بيانات تسجيل الدخول غير صحيحة')->withInput();
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
