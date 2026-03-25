<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */




        public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('customer_id')) {
            return redirect('/checkout')
                ->with('error', 'Please login first');
        }

        return $next($request);
    }

}
