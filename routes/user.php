<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController;

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\EmailController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/cart/add/{product_id}/{value_id}', [CartController::class, 'add'])->name('cart.add');

Route::get('/cart/increase/{key}', [CartController::class, 'increase'])->name('cart.increase');
Route::get('/cart/decrease/{key}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::get('/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
//checkout User order


Route::get('/order/{id}', [CartController::class, 'view'])->name('order.view');

//Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('user.orders');
Route::get('/my-orders', [\App\Http\Controllers\User\OrderController::class, 'index'])
    ->name('user.orders')
    ->middleware('userlogin'); // ensure user must be logged in

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('user.login');
Route::post('/login', [AuthController::class, 'login']);

// Logout

Route::get('/user/logout', [AuthController::class, 'logout'])->name('logout');
//
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout')
    ->middleware(['userlogin']);
Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');

Route::get('/email-form', function () {
    return view('User.email.form');
})->name('email.form');
Route::post('/send-email', [EmailController::class, 'send'])->name('send.email');

Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');

/*Route::get('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::get('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');*/
