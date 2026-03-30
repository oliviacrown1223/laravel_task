<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CouponController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'usage_limit' => 'required|integer|min:1|max:10000',

            'expiry_date' => 'required|date|after:today',

            'type' => 'required|in:percentage,fixed',

            'discount' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type == 'percentage' && $value > 100) {
                        $fail('Percentage cannot be more than 100');
                    }
                }
            ],
        ]);


        Coupon::create([
            'name' => $request->name,
            'code' => strtoupper(Str::random(8)), // 🔥 AUTO CODE
            'usage_limit' => $request->usage_limit,
            'expiry_date' => $request->expiry_date,
            'type' => $request->type,
            'discount' => $request->discount,
        ]);

        return back()->with('success', 'Coupon created');
    }

    public function index()
    {
         return view('admin.coupon.index');
    }
}
