<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    //

    public function showLogin(){
        return view('admin.auth.login');
    }

    public function login(Request $request){
        $credentials = $request->only('email','password'); // for security
        if(Auth::guard('admin')->attempt($credentials)){
            //return view('admin.dashboard');
            return redirect()->route('admin.chart');
        }
        return redirect()->route('admin.login');
    }
    public function dashboard(){
        $admin = Auth::guard('admin')->user();

       // dd($admin);
        return view('admin.dashboard',compact('admin'));
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
