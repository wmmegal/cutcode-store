<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
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

Route::get('/', HomeController::class)->name('home');

Route::get('/catalog/{category:slug?}', CatalogController::class)->name('catalog');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
