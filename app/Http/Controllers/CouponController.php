<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CouponController extends Controller
{
    public function create()
    {
        return view('admin.coupon.index'); // your big blade code
    }

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
            'code' => $request->code ?? strtoupper(Str::random(8)), // 🔥 AUTO CODE
            'usage_limit' => $request->usage_limit,
            'used_count' => 0,
            'expiry_date' => $request->expiry_date,
            'type' => $request->type,
            'discount' => $request->discount,
        ]);


        return redirect()->route('coupon.index')
            ->with('success', 'Coupon added successfully');

    }

    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupon.coupon', compact('coupons'));
    }

    public function delete($id)
    {
         Coupon::destroy($id);
        return redirect()->route('coupon.index');
    }
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.EditCoupon', compact('coupon'));
    }
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'usage_limit' => 'required|integer|min:1|max:10000',
            'expiry_date' => 'required|date',
            'type' => 'required|in:percentage,fixed',
            'discount' => 'required|numeric|min:1',
        ]);

        $coupon->update([
            'name' => $request->name,
            'code' => $request->code, // ✅ NOW EDITABLE
            'usage_limit' => $request->usage_limit,
            'expiry_date' => $request->expiry_date,
            'type' => $request->type,
            'discount' => $request->discount,
        ]);

        return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully');
    }
}
