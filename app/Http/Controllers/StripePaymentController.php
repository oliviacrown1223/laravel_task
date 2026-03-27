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

            return back()->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
