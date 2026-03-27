<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\StripePaymentController;

/*require __DIR__.'/../routes/user.php';
require __DIR__.'/../routes/admin.php';*/





// Show login form
Route::get('/login-admin', [UserController::class, 'showLoginForm'])->name('admin.login');

// Handle login
Route::post('/login-admin', [UserController::class, 'login'])->name('admin.login.submit');

Route::get('/test-gmail', function () {
    try {
        Mail::raw('Test mail from Laravel ✅', function ($message) {
            $message->to('test2@example.com') // replace with recipient email
            ->subject('Laravel Gmail Test');
        });

        return "Mail sent successfully!";
    } catch (\Exception $e) {
        return "Mail sending failed: " . $e->getMessage();
    }
});


Route::get('/check-mail', function () {
    return [
        'mailer' => config('mail.default'),
        'host' => config('mail.mailers.smtp.host'),
        'port' => config('mail.mailers.smtp.port'),
        'username' => config('mail.mailers.smtp.username'),
        'password' => config('mail.mailers.smtp.password') ,
        'encryption' => config('mail.mailers.smtp.encryption'),
        'from_address' => config('mail.from.address'),
        'from_name' => config('mail.from.name'),
    ];
});

Route::get('/stripe', [StripePaymentController::class, 'stripe'])->name('stripe.form');
Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');
