<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Customer;
class AdminController extends Controller
{
    public function adminPage()
    {
        if(!session()->has('admin'))
        {
            return redirect('/login');
        }

        return "admin are ok";
    }
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalBrands = Brand::count();
        $totalCategories = Category::count();
        $totalVariants = ProductVariant::count();

        $lowStockProducts = ProductVariant::whereColumn('stock', '<=', 'minStock')
            ->with('product', 'value')
            ->get();

        $recentProducts = Product::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalBrands',
            'totalCategories',
            'totalVariants',
            'lowStockProducts',
            'recentProducts'
        ));

    }
    public function customers()
    {
        // Get all customers from database
        $customers = \App\Models\Customer::withCount('orders')->get();

        return view('admin.Customers.customers', compact('customers'));
    }
}
