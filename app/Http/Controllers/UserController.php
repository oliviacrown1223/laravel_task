<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class UserController extends Controller
{
    function login(Request $req)
    {
        $user = Admin::where('email',$req->email)
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
    }
    public function logout()
    {
        session()->forget('admin');   // remove admin session
        return redirect('/login');
    }
}
