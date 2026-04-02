<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\EmailSetting;
use App\Models\Coupon;
use Carbon\Carbon;
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
        $customer_id = session()->get('customer_id');

        if ($customer_id) {
            \App\Models\Customer::where('id', $customer_id)
                ->increment('total_orders');
        }
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

        $coupon = session()->get('coupon');
        $discount = 0;

        if ($coupon) {

            $couponData = \App\Models\Coupon::find($coupon['id']);

            // ❌ Coupon not found
            if (!$couponData) {
                return back()->with('error', 'Invalid coupon');
            }

            // ❌ Expired check
            if ($couponData->expiry_date && $couponData->expiry_date < now()) {
                return back()->with('error', 'Coupon expired');
            }

            // ❌ Usage limit check (🔥 IMPORTANT)
            if ($couponData->used_count >= $couponData->usage_limit) {
                return back()->with('error', 'Coupon usage limit reached');
            }

            // ✅ Apply discount
            if ($coupon['type'] == 'percentage') {
                $discount = ($total * $coupon['discount']) / 100;
            } else {
                $discount = $coupon['discount'];
            }

            // ✅ Increase usage count
            $couponData->increment('used_count');

        }

// ✅ Final total
        $finalTotal = $total - $discount;

// ✅ Update order with final amount
        $order->update([
            'total_amount' => $finalTotal,
            'discount_amount' => $discount
        ]);

// ✅ Remove coupon after use
        session()->forget('coupon');
        session()->forget('cart');

        // ✅ Clear cart

        // Load dynamic config


       /* if ($request->payment_type == 'online') {

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $lineItems = [];

            foreach ($cart as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => $item['price'] * 100,
                    ],
                    'quantity' => $item['qty'],
                ];
            }

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',

                // 🔥 IMPORTANT: pass order id
                'success_url' => route('payment.success', $order->id),
                'cancel_url' => route('payment.cancel', $order->id),
            ]);

            return redirect($session->url);
        }
        if ($request->payment_type == 'cod' || $request->payment_type == 'upi') {

            session()->forget('cart'); // ✅ move here

            return redirect()->route('order.view', $order->id)
                ->with('success', 'Order placed successfully!');
        }*/




        EmailSetting::create([
            'mailer' => Config::get('mail.default'),
            'host' => Config::get('mail.mailers.smtp.host'),
            'port' => Config::get('mail.mailers.smtp.port'),
            'username' => Config::get('mail.mailers.smtp.username'),
            'password' => Config::get('mail.mailers.smtp.password'),
            'encryption' => Config::get('mail.mailers.smtp.encryption'),
            'from_email' => Config::get('mail.from.address'),
            'from_name' => Config::get('mail.from.name'),
        ]);
        $setting = EmailSetting::latest()->first();
        // ✅ Apply config dynamically

        if ($setting) {
            Config::set('mail.default', $setting->mailer);

            Config::set('mail.mailers.smtp.host', $setting->host);
            Config::set('mail.mailers.smtp.port', $setting->port);
            Config::set('mail.mailers.smtp.username', $setting->username);
            Config::set('mail.mailers.smtp.password', $setting->password);
            Config::set('mail.mailers.smtp.encryption', $setting->encryption);

            Config::set('mail.from.address', $setting->from_email);
            Config::set('mail.from.name', $setting->from_name);
        }

        // ===============================
        // 📩 SEND MAIL
        // ===============================

       /* try {
            Mail::to($order->email)->send(new OrderPlacedMail($order));
        } catch (\Exception $e) {
            \Log::error('Mail failed: ' . $e->getMessage());
        }*/




            return redirect()->route('order.view', $order->id)
                ->with('success', 'Order placed successfully!');



    }
    public function paymentSuccess($id)
    {
        $order = Order::findOrFail($id);
        EmailSetting::create([
            'mailer' => Config::get('mail.default'),
            'host' => Config::get('mail.mailers.smtp.host'),
            'port' => Config::get('mail.mailers.smtp.port'),
            'username' => Config::get('mail.mailers.smtp.username'),
            'password' => Config::get('mail.mailers.smtp.password'),
            'encryption' => Config::get('mail.mailers.smtp.encryption'),
            'from_email' => Config::get('mail.from.address'),
            'from_name' => Config::get('mail.from.name'),
        ]);
        $setting = EmailSetting::latest()->first();
        // ✅ Apply config dynamically

        if ($setting) {
            Config::set('mail.default', $setting->mailer);

            Config::set('mail.mailers.smtp.host', $setting->host);
            Config::set('mail.mailers.smtp.port', $setting->port);
            Config::set('mail.mailers.smtp.username', $setting->username);
            Config::set('mail.mailers.smtp.password', $setting->password);
            Config::set('mail.mailers.smtp.encryption', $setting->encryption);

            Config::set('mail.from.address', $setting->from_email);
            Config::set('mail.from.name', $setting->from_name);
        }

        // ===============================
        // 📩 SEND MAIL
        // ===============================

        try {
            Mail::to($order->email)->send(new OrderPlacedMail($order));
        } catch (\Exception $e) {
            \Log::error('Mail failed: ' . $e->getMessage());
        }






        // ✅ Mark as paid
        $order->update([
            'payment_status' => 'done'
        ]);

        // ✅ Clear cart here (AFTER payment)
        session()->forget('cart');

        return view('payment-success', compact('order'));
    }

    public function paymentCancel($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'payment_status' => 'pending'
        ]);

        return redirect()->route('checkout')
            ->with('error', 'Payment cancelled!');
    }


    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required'
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid coupon');
        }

        if ($coupon->expiry_date < now()) {
            return back()->with('error', 'Coupon expired');
        }

        if ($coupon->used_count >= $coupon->usage_limit) {
            return back()->with('error', 'Coupon limit reached');
        }

        session()->put('coupon', $coupon);

        return back()->with('success', 'Coupon applied');
    }
}
