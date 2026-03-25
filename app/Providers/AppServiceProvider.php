<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $customer_id = session()->get('customer_id');

            $orderCount = 0;
            if ($customer_id) {
                $orderCount = Order::where('customer_id', $customer_id)->count();
            }

            $view->with('orderCount', $orderCount);
        });
    }
}
