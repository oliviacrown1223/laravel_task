<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controllers
{
    // Show Register
    public function showRegister()
    {
        return view('User.auth.register');
    }

    // Register Save
    public function register(Request $request)
    {
        // Simple manual validation
        if (
            empty($request->name) ||
            empty($request->phone) ||
            empty($request->email) ||
            empty($request->password)
        ) {
            return back()->with('error', 'All fields are required')->withInput();
        }

        // Check email already exists
        $check = \App\Models\Customer::where('email', $request->email)->first();
        if ($check) {
            return back()->with('error', 'Email already exists')->withInput();
        }

        // Insert data
        \App\Models\Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('user.login')->with('success', 'Register successful');
    }

    // Show Login
    public function showLogin()
    {
        return view('User.auth.login');
    }

    // Login Check
    public function login(Request $request)
    {
        $user = Customer::where('email', $request->email)->first();

        if ($user && $request->password == $user->password)
        {
            Session::put('user_id', $user->id);

            return redirect('/checkout');
        }

        return back()->with('error', 'Invalid Email or Password');
    }

    // Logout
    public function logout()
    {
        Session::forget('user_id');
        return redirect()->route('user.login'); // ✅ FIXED
    }
}
