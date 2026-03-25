<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function userOrders()
    {
        $orders = \App\Models\Order::latest()->get();

        return view('User.my_orders', compact('orders'));
    }
    public function index()
    {

        // ✅ Get logged-in customer ID
        $customer_id = session()->get('customer_id');

        if (!$customer_id) {
            return redirect()->route('user.login')
                ->with('error', 'Please login first');
        }

        // ✅ Get orders for this customer
        $orders = Order::where('customer_id', $customer_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('User.my_orders', compact('orders'));
    }
}
