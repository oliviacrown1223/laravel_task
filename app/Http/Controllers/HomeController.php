<?php

namespace App\Http\Controllers;

use App\Models\Brand;
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
    public function list()
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
        ));;
        return view('Home',compact('product'));
        //return "ok";
    }
    public function brandsList()
    {
        $brands = Brand::all();
        return view('Home',compact('brands'));
    }
}
