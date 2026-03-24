<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


/*require __DIR__.'/../routes/user.php';
require __DIR__.'/../routes/admin.php';*/





// Show login form
Route::get('/login-admin', [UserController::class, 'showLoginForm'])->name('admin.login');

// Handle login
Route::post('/login-admin', [UserController::class, 'login'])->name('admin.login.submit');


