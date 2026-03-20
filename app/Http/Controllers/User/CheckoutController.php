<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
  /*  public function index()
    {
        $cart = session()->get('cart', []);

        if(empty($cart)){
            return redirect('/')->with('error', 'Cart is empty');
        }

        return view('User.checkout', compact('cart'));
    }

    public function place(Request $request)
    {
        /*$cart = session()->get('cart', []);

        if(empty($cart)){
            return back()->with('error', 'Cart is empty');
        }

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $total = 0;

        foreach($cart as $item){
            $total += $item['price'] * $item['qty'];
        }

        // ✅ Better Order ID (avoid duplicate issue)
        $orderId = 'OD_' . strtoupper(uniqid());

        // ✅ Create Order
        $order = Order::create([
            'order_id' => $orderId,
            'customer_name' => $request->name,
            'email' => $request->email ?? null,
            'phone_no' => $request->phone,
            'address' => $request->address,
            'pincode' => $request->pincode ?? null,
            'total_amount' => $total,
            'payment_type' => $request->payment_type ?? 'offline',
            'payment_status' => 'pending'
        ]);

        // ✅ Save Order Items
        foreach($cart as $item){

            OrderItem::create([
                'order_id' => $order->id,
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);

            // 🔥 IMPORTANT: Reduce Stock
            \App\Models\ProductVariant::where('product_id', $item['product_id'])
                ->where('value_id', $item['value_id'])
                ->decrement('stock', $item['qty']);
        }

        // ✅ Clear Cart
        session()->forget('cart');

        return redirect()->route('order.view', $order->id);
    }


        $cart = session()->get('cart', []);
        dump($cart);
        if(empty($cart)){
            return back()->with('error', 'Cart is empty');
        }

        // ✅ Create Order
        $order = Order::create([
            'order_id' => uniqid(),

            'customer_name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone,
            'address' => $request->address,
            'pincode' => $request->pincode,

            'total_amount' => 0,
            'payment_type' => $request->payment_type,
        ]);

        // ✅ Save Items
        $total = 0;

        foreach($cart as $item){

            $lineTotal = $item['price'] * $item['qty'];
            $total += $lineTotal;

            OrderItem::create([
                'order_id' => $order->id,
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        // ✅ Update Total
        $order->update([
            'total_amount' => $total
        ]);

        // ✅ Clear cart
        session()->forget('cart');

        return redirect()->route('order.view', $order->id);
    }*/
    public function index()
    {
        $cart = session()->get('cart', []);

        if(empty($cart)){
            return redirect('/')->with('error', 'Cart is empty');
        }

        return view('User.checkout', compact('cart'));
    }

    public function place(Request $request)
    {
        $cart = session()->get('cart', []);

        if(empty($cart)){
            return back()->with('error', 'Cart is empty');
        }

        // ✅ Create Order
        $order = Order::create([
            'order_id' => 'OD_' . strtoupper(uniqid()),
            'customer_name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'total_amount' => 0,
            'payment_type' => $request->payment_type,
            'payment_status' => 'pending'
        ]);

        $total = 0;

        // ✅ Save Order Items
        foreach($cart as $item){

            $lineTotal = $item['price'] * $item['qty'];
            $total += $lineTotal;

            OrderItem::create([
                'order_id' => $order->id,
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        // ✅ Update total
        $order->update([
            'total_amount' => $total
        ]);

        // ✅ Clear cart
        session()->forget('cart');

        return redirect()->route('order.view', $order->id);
    }
}
