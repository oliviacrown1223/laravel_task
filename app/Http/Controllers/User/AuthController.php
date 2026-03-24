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

    public function register(Request $request)
    {
        // ✅ Validation (BEST PRACTICE)
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // ✅ Create User
        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password), // ✅ FIXED
        ]);

        return redirect()->route('user.login')->with('success', 'Register successful');
    }

    // Show Login
    public function showLogin()
    {
        return view('User.auth.login');
    }

    // Login Check
  /*  public function login(Request $request)
    {
        $user = Customer::where('email', $request->email)->first();

        if ($user && $request->password == $user->password)
        {
            Session::put('user_id', $user->id);

            return redirect('/checkout');
        }

        return back()->with('error', 'Invalid Email or Password');
    }*/

    public function login(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ✅ Find user
        $user = Customer::where('email', $request->email)->first();

        // ✅ Check password with HASH (IMPORTANT)
        if ($user && Hash::check($request->password, $user->password)) {

            // ✅ Store session
            Session::put('customer_id', $user->id);
            Session::put('customer', $user); // optional (for name display)

            return redirect('/checkout')->with('success', 'Login successful');
        }

        // ❌ Failed
        return back()->with('error', 'Invalid Email or Password');
    }
    // Logout


    public function logout()
    {
        // ✅ Remove all session data
        Session::forget('customer_id');
        Session::forget('customer');

        // OR destroy full session
        Session::flush();

        return redirect('/')->with('success', 'Logout successful');
    }
}
