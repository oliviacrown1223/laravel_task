<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
       // return view('user.checkout');
        // 🔒 Login check
        if (!session()->has('customer_id')) {
            return redirect()->route('user.login')
                ->with('error', 'Please login first');
        }

        // 🛒 Cart check
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/')->with('cart_empty', true);
        }

        return view('User.checkout', compact('cart'));
    }

    public function place(Request $request)
    {
        // ✅ Validate request data
        $validated = $request->validate([
            'name' => 'required|regex:/^[A-Za-z\s]+$/|max:255',
            'email'        => 'required|email|max:255',
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'address'      => 'required|string|max:500',
            'pincode'      => 'required|string|max:6',
            'payment_type' => 'required|in:cod,online,upi',
        ]);

        // ✅ Get cart from session
        $cart = session()->get('cart', []);
        if(empty($cart)){
            return back()->with('error', 'Cart is empty');
        }

        // ✅ Create Order
        $order = Order::create([
            'order_id'       => 'OD_' . strtoupper(uniqid()),
            'customer_name'  => $validated['name'],
            'customer_id'    => session()->get('customer_id'),
            'email'          => $validated['email'],
            'phone_no'       => $validated['phone'],
            'address'        => $validated['address'],
            'pincode'        => $validated['pincode'],
            'total_amount'   => 0,
            'payment_type'   => $validated['payment_type'],
            'payment_status' => 'pending'
        ]);

        $total = 0;

        // ✅ Save Order Items
        foreach($cart as $item){
            $lineTotal = $item['price'] * $item['qty'];
            $total += $lineTotal;

            OrderItem::create([
                'order_id' => $order->id,
                'name'     => $item['name'],
                'qty'      => $item['qty'],
                'price'    => $item['price'],
            ]);
        }

        // ✅ Update total
        $order->update([
            'total_amount' => $total
        ]);

        // ✅ Clear cart
        session()->forget('cart');

        return redirect()->route('order.view', $order->id)
            ->with('success', 'Order placed successfully!');
    }
}
