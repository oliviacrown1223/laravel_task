<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;




class UserController extends Controller
{
    /*public function login(Request $req)
    {
        $user = Admin::where('email',$req->email )
            ->where('password',$req->password)
            ->first();

        if($user)
        {
            if($user->role == "admin")
            {
                session()->put('admin',$user->email);
                return redirect('/admin');
            }
            else
            {
                return back()->with('msg','You are not admin');
            }
        }
        else
        {
            return back()->with('msg','Login failed');
        }

    }*/
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $req)
    {
        $user = Admin::where('email', $req->email)->first();

        if ($user && $req->password == $user->password) {

            if ($user->role == "admin") {

                Session::put('admin_id', $user->id); // ✅ MUST MATCH
            //    dd(Session::all());
                return redirect('/dashboard');
            }

            return back()->with('msg', 'You are not admin');
        }

        return back()->with('msg', 'Invalid email or password');
    }
    public function logout()
    {
      //  session()->forget('admin');
        session()->forget('admin_id');// remove admin session
        return redirect('/login-admin');
    }
}
