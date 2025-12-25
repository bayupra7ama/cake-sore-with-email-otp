<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    return view('welcome');

});


Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');
/*
|--------------------------------------------------------------------------
| OTP (SETELAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/otp', [OtpController::class, 'show'])
        ->name('otp.form');

    Route::post('/otp/send', [OtpController::class, 'send'])
        ->name('otp.send');

    Route::post('/otp', [OtpController::class, 'verify'])
        ->name('otp.verify');
});


/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'otp'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name("dashboard");

});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'otp'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);

    Route::delete(
        'admin/products/{product}/image/{image}',
        [ProductController::class, 'deleteImage']
    )->name('products.image.delete');

});

/*
|--------------------------------------------------------------------------
| PROFILE (AUTH ONLY)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN, REGISTER, LOGOUT)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
