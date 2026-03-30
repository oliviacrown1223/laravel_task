<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
class StripePaymentController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Stripe\Charge::create([
                "amount" => $request->amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test Payment",
            ]);

            $orderId = session()->get('order_id');

            $order = \App\Models\Order::with('items')->find($orderId);

            if ($order) {

                // ✅ UPDATE STATUS (pending → success)
                $order->update([
                    'payment_status' => 'success'
                ]);

                // ✅ SEND EMAIL
                \Mail::to($order->email)->send(new \App\Mail\OrderPlacedMail($order));

                // ✅ CLEAR CART
                session()->forget('cart');
            }

            // ✅ REDIRECT SUCCESS PAGE
            return redirect()->route('payment.success');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
