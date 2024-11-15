<?php

use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;


// Route::get('/welcome', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $products = App\Models\Product::where('ItemType', 'like', '%game%')
        ->orderBy('ProductName')
        ->paginate(20);
    return view('index', compact('products'));
})->name("/");

Route::get('/about', function () {
    return view('about');
});

Route::get('/xbox-original', function () {
    $products = App\Models\Product::where('ItemType', 'like', '%xbox%')
        ->orderBy('ProductName')
        ->paginate(20);
    return view('xbox-original', compact('products'));
})->name('xbox.original');

Route::get('/ps2', function () {
    $products = App\Models\Product::where('ItemType', 'like', '%Playstation 2%')
        ->orderBy('ProductName')
        ->paginate(20);
    return view('/ps2', compact('products'));
})->name('/ps2');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerLoginController::class, 'login'])->name('login.submit');

Route::get('/logout', [CustomerLoginController::class, 'logout'])->name('logout');
Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('customer/auth/register');
});

Route::get('/products/show/{id}', [ProductController::class, 'show'])->name('products.show');

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

// Cart Routes

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');


Route::get('paypal/payment', [CartController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/payment/success', [CartController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [CartController::class, 'paymentCancel'])->name('paypal.payment.cancel');
