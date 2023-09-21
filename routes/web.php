<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDeleteController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\CatalogViewMiddleware;
use App\Livewire\Cart;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::get('/catalog/{category:slug?}', CatalogController::class)
     ->middleware([CatalogViewMiddleware::class])
     ->name('catalog');

Route::get('/product/{product:slug}', ProductController::class)->name('product');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');

    Route::get('/forgot-password', 'passwordRequest')->name('password.request');
    Route::get('/reset-password/{token}', 'resetPassword')->name('password.reset');

    Route::post('signIn', 'signIn')->name('signIn');
    Route::post('signUp', 'signUp')->name('signUp');

    Route::post('/forgot-password', 'passwordEmail')->middleware('guest')->name('password.email');
    Route::post('/reset-password', 'passwordUpdate')->middleware('guest')->name('password.update');

    Route::delete('logout', 'logout')->name('logout');

    Route::get('/auth/socialite/github', 'github')->name('socialite.github');
    Route::get('/auth/socialite/github/callback', 'githubCallback')->name('socialite.github.callback');
});

Route::middleware('web')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'handle'])->name('checkout.handle');
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::controller(CartController::class)
     ->prefix('cart')
     ->group(function () {
         Route::post('/{product}', 'add')->name('cart.add');
         Route::post('/{item}/quantity', 'quantity')->name('cart.quantity');
         Route::delete('/{item}/delete', 'delete')->name('cart.delete');
         Route::delete('/truncate', 'truncate')->name('cart.truncate');
     });

// Livewire
Route::get('/cart', Cart::class)->name('cart');

// My account
Route::prefix('/account')->middleware('auth')->group(function () {
    Route::get('/orders', OrdersController::class)->name('account.orders');
    Route::get('/orders/{order}', OrderController::class)->name('account.order');
    Route::delete('/orders/{order}', OrderDeleteController::class)->name('account.orders.delete');
});

//Stripe
Route::post('/webhooks/stripe', StripeWebhookController::class)->name('webhooks.stripe');


