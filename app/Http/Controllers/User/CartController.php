<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
class CartController extends Controllers
{
    public function add($product_id, $value_id)
    {



        $product = Product::findOrFail($product_id);

        $variant = ProductVariant::where('product_id', $product_id)
            ->where('value_id', $value_id)
            ->first();

        if(!$variant || $variant->stock <= 0){
            return back()->with('error', 'Stock not available');
        }

        $cart = session()->get('cart', []);

        $key = $product_id . '_' . $value_id;

        $currentQty = isset($cart[$key]) ? $cart[$key]['qty'] : 0;

        if($currentQty >= $variant->stock){
            return back()->with('error', 'Stock not available');
        }

        if(isset($cart[$key])){
            $cart[$key]['qty']++;
        } else {
            $cart[$key] = [
                "product_id" => $product_id,
                "value_id" => $value_id,
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "qty" => 1,
                "stock" => $variant->stock   // ✅ FIX HERE
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Added to cart');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('User.cart', compact('cart'));
    }
   /* public function increase($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])){
            $cart[$id]['qty']++;
            session()->put('cart', $cart);
        }

        return back();
    }*/
    public function increase($key)
    {
        $cart = session()->get('cart');

        if(isset($cart[$key])){

            $product_id = $cart[$key]['product_id'];
            $value_id = $cart[$key]['value_id'];

            $variant = ProductVariant::where('product_id', $product_id)
                ->where('value_id', $value_id)
                ->first();

            if($cart[$key]['qty'] >= $variant->stock){
                return back()->with('error', 'Stock not available');
            }

            $cart[$key]['qty']++;
            session()->put('cart', $cart);
        }

        return back();
    }

    public function decrease($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])){
            if($cart[$id]['qty'] > 1){
                $cart[$id]['qty']--;
            } else {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back();
    }

    public function view($id)
    {
        $order = \App\Models\Order::with('items')->findOrFail($id);
        return view('User.order_view', compact('order'));
    }

}
