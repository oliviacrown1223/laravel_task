<?php

/*use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;



Route::get('/',[HomeController::class,'list']);

Route::view('/login','login');


Route::post('/login',[UserController::class,'login']);


Route::get('/admin',[ProductController::class,'index'])->middleware('adminauth');

Route::post('/product-add',[ProductController::class,'store']);

Route::get('/delete/{id}',[ProductController::class,'delete']);


Route::get('/edit/{id}', [ProductController::class,'edit']);

Route::post('/update/{id}', [ProductController::class,'update']);*/


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


require __DIR__.'/../routes/user.php';
require __DIR__.'/../routes/admin.php';


Route::view('/login','login');
Route::post('/login',[UserController::class,'login']);






