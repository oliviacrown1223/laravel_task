<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // ✅ View Single Order
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.view', compact('order'));
    }

    // ✅ Update Status
    public function toggleStatus($id)
    {
        $order = Order::findOrFail($id);

        $order->payment_status = $order->payment_status == 'pending' ? 'done' : 'pending';
        $order->save();

        return redirect()->back()->with('success', 'Status updated');
    }
    public function delete($id)
    {
        Order::destroy($id); // Delete the order (will also cascade to order_items if foreign key set)
        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully');
    }
}
