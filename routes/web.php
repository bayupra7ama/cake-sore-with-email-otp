<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\USer\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\User\HomeController;

use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\User\ProductDetailController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Admin\DashboardController;



/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/




Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::get('/product/{slug}', [ProductDetailController::class, 'show'])
    ->name('product.detail');
Route::get('/checkout', fn() => view('user.pages.checkout'))->name('checkout');


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
Route::middleware(['auth', 'otp'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])
            ->name('cart.update');

        Route::get('/checkout', [OrderController::class, 'checkout'])
            ->name('checkout');

        Route::post('/order', [OrderController::class, 'store'])
            ->name('order.store');

        Route::get('/my-order', [OrderController::class, 'index'])
            ->name('order.index');



        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');

    });


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'otp'])->prefix('admin')->name('admin.')->group(function () {



    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);

    Route::delete(
        'admin/products/{product}/image/{image}',
        [ProductController::class, 'deleteImage']
    )->name('products.image.delete');

    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('orders.show');

    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.update-status');

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
