<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function userOrders()
    {
        $orders = \App\Models\Order::latest()->get();

        return view('User.my_orders', compact('orders'));
    }
}
