<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Menu;


class HomeController extends Controller
{
    public function index()
    {
        $product = Product::all();

        $setting = Setting::first();
        $headerMenus = Menu::where('type','header')->get();
        $footerMenus = Menu::where('type','footer')->get();

        $cart = session()->get('cart', []);
        $count = count($cart);

        return view('home', compact(
            'product',
            'setting',
            'headerMenus',
            'footerMenus',
            'count'
        ));
    }
}
