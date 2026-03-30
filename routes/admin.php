<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EditCatagoryController;
use App\Http\Controllers\EditBrandController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VariantsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmailSettingController;
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


/*Route::get('/admin', [AdminController::class, 'dashboard'])
    ->middleware('adminauth')
    ->name('admin.home');*/
Route::get('/admin', [AdminController::class, 'dashboard'])
    ->middleware('adminauth')
    ->name('admin.dashboard');

Route::get('/admin/products',[ProductController::class,'index'])
    ->name('products.index');

Route::post('/admin/logout', [UserController::class, 'logout'])->name('admin.logout');


Route::get('/admin/product-add',[ProductController::class,'create'])->name('product.create');
Route::post('/admin/product-add',[ProductController::class,'store'])->name('product.store');
Route::get('/delete/{id}',[ProductController::class,'delete'])->name('product.delete');
Route::get('/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
Route::post('/update/{id}',[ProductController::class,'update'])->name('product.update');


Route::get('/brand', [ProductController::class, 'createbrand'])->name('brand.brandindex');
Route::get('/admin/add-brand',[ProductController::class,'createbrand'])->name('brand.create');
Route::post('/admin/add-brand',[ProductController::class,'storebrand'])->name('brand.store');
Route::get('/brand/delete/{id}',[ProductController::class,'deletebrand'])->name('brand.delete');
Route::get('/brand/edit/{id}', [App\Http\Controllers\EditBrandController::class,'edit'])->name('brand.edit');
Route::put('/brand/update/{id}', [App\Http\Controllers\EditBrandController::class,'update'])->name('brand.update');
Route::get('/brand/status/{id}',[EditBrandController::class,'changeStatus'])->name('brand.status');

/*Route::post('/product-add',[ProductController::class,'storee'])->name('product.add');*/

Route::get('/variants', [App\Http\Controllers\VariantsController::class, 'index'])->name('variants.index');
Route::post('/admin/add-variants',[VariantsController::class,'store'])->name('variants.store');
Route::get('/variants/delete/{id}',[VariantsController::class,'delete'])->name('variants.delete');
Route::get('/variants/status/{id}',[VariantsController::class,'changeStatus'])->name('variants.status');
Route::get('/variants/edit/{id}', [App\Http\Controllers\VariantsController::class,'edit'])->name('variants.edit');
Route::put('/variants/update/{id}', [App\Http\Controllers\VariantsController::class,'update'])->name('variants.update');


Route::get('/catagory', [CategoryController::class, 'createcatagory'])->name('catagory.catagoryindex');
Route::get('/admin/add-catagory',[CategoryController::class,'createcatagory'])->name('catagory.create');
Route::post('/admin/add-catagory',[CategoryController::class,'storecatagory'])->name('catagory.store');
Route::get('/catagory/delete/{id}',[CategoryController::class,'deletecatagory'])->name('catagory.delete');
Route::get('/catagory/edit/{id}', [App\Http\Controllers\EditCatagoryController::class,'edit'])->name('catagory.edit');
Route::put('/catagory/update/{id}', [App\Http\Controllers\EditCatagoryController::class,'update'])->name('catagory.update');
Route::get('/catagory/status/{id}',[EditCatagoryController::class,'changeStatus'])->name('catagory.status');


Route::get('/themes/settings', [ThemeController::class, 'settings'])->name('themes.settings');
Route::post('/themes/settings', [ThemeController::class, 'saveSettings'])->name('themes.save');



Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
Route::post('/menus/store', [MenuController::class, 'store'])->name('menus.store');
Route::get('/menus/edit/{id}', [App\Http\Controllers\MenuController::class,'edit'])->name('menus.edit');
Route::put('/menus/update/{id}', [App\Http\Controllers\MenuController::class,'update'])->name('menus.update');
Route::get('/menus/delete/{id}',[MenuController::class,'delete'])->name('menus.delete');


Route::prefix('admin')->group(function () {

    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');

    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.view');

    Route::get('/admin/orders/delete/{id}', [OrderController::class, 'delete'])->name('admin.orders.delete');

    Route::post('/orders/status/{id}', [OrderController::class, 'toggleStatus'])->name('admin.orders.status');

});


Route::put('/admin/orders/status/{id}', [OrderController::class, 'toggleStatus'])
    ->name('admin.orders.status');

Route::get('/admin/customers', [App\Http\Controllers\AdminController::class, 'customers'])
    ->name('admin.customers');

//Email-Satting

Route::get('/admin/email-settings', [EmailSettingController::class, 'index'])->name('admin.email-settings');
Route::post('/admin/email-settings', [EmailSettingController::class, 'store']);
Route::get('/admin/test-mail', [EmailSettingController::class, 'test'])->name('email.test');


//Coupon

Route::get('admin/coupons', [CouponController::class, 'index'])->name('admin.coupons');
Route::post('/admin/coupon/store', [CouponController::class, 'store'])->name('coupon.store');
