<?php

use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Route::get('/welcome', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/xbox-original', function () {
    return view('xbox-original');
});

Route::get('ps2', function () {
    return view('ps2');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/customer/account', function () {
    return view('/customer/account');
});


Route::post('/login', [CustomerLoginController::class, 'login']);
Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('customer/auth/register');
});

// Route::get('/products', function () {
//     return view('products');
// });

// Route::get('/single-product', function () {
//     return view('single-product');
// });

Route::get('/customer/account/{customerId?}', [CustomerController::class, 'account'])
    ->name('customer.account')
    ->middleware('auth:customer');


Route::resources([
    'customers' => CustomerController::class,
    'products' => ProductController::class,
    'orders' => OrderController::class,
    'order-item' => OrderItemController::class,
    'review' => ReviewController::class,
]);
