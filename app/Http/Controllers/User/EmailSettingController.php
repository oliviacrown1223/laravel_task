<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\EmailSetting;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
class EmailSettingController extends Controller
{
    public function test()
    {
        // Check if an EmailSetting already exists with the same 'from_email' or other unique field
        $existing = EmailSetting::where('from_email', Config::get('mail.from.address'))->first();

        if (!$existing) {
            // Only create a new record if it doesn't exist
            EmailSetting::create([
                'mailer'     => Config::get('mail.default'),
                'host'       => Config::get('mail.mailers.smtp.host'),
                'port'       => Config::get('mail.mailers.smtp.port'),
                'username'   => Config::get('mail.mailers.smtp.username'),
                'password'   => Config::get('mail.mailers.smtp.password'),
                'encryption' => Config::get('mail.mailers.smtp.encryption'),
                'from_email' => Config::get('mail.from.address'),
                'from_name'  => Config::get('mail.from.name'),
            ]);
        }

        // Get the latest (or existing) setting
        $setting = EmailSetting::latest()->first();

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

        try {
            $order = \App\Models\Order::with('items')->latest()->first();

            if (!$order) {
                return "No order found!";
            }

            Mail::to($order->email)->send(new OrderPlacedMail($order));

            return redirect("/my-orders")
                ->with('success', 'Email sent successfully!');

        } catch (\Exception $e) {
            // Redirect to the email settings page on error
            return redirect('/admin/email-settings')
                ->with('error', 'Error sending email: ' . $e->getMessage());
        }
    }
    /*public function test(Request $request)
    {
        // validation...

        $cart = session()->get('cart', []);
        if(empty($cart)){
            return back()->with('error', 'Cart is empty');
        }

        // ✅ Create Order
        $order = Order::create([
            'order_id' => 'OD_' . strtoupper(uniqid()),
            'customer_name' => $request->name,
            'customer_id' => session()->get('customer_id'),
            'email' => $request->email,
            'phone_no' => $request->phone,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'total_amount' => 0,
            'payment_type' => $request->payment_type,
            'payment_status' => 'pending'
        ]);

        session()->put('order_id', $order->id); // ⭐ important

        // ✅ Save items (same as your code)

        // 👉 COD
        if($request->payment_type == 'cod'){
            $order->update(['payment_status' => 'success']);

            Mail::to($order->email)->send(new OrderPlacedMail($order));

            session()->forget('cart');

           // return redirect('/my-orders')->with('success', 'Order placed successfully!');
            return redirect('/stripe');
        }

        // 👉 ONLINE → redirect to Stripe
        return redirect('/stripe');
    }
    public function paymentSuccess()
    {
        $orderId = session()->get('order_id');

        $order = Order::with('items')->find($orderId);

        if(!$order){
            return redirect('/')->with('error', 'Order not found');
        }

        // ✅ Update payment status
        $order->update([
            'payment_status' => 'success'
        ]);

        // ✅ Send mail
        Mail::to($order->email)->send(new OrderPlacedMail($order));

        // ✅ Clear cart
        session()->forget('cart');

        return redirect('/my-orders')->with('success', 'Payment successful & order placed!');
    }*/
}
