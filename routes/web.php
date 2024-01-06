<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware(['auth']);

Route::controller(\App\Http\Controllers\Login::class)->middleware([\App\Http\Middleware\Login::class])
    ->group(function () {
        Route::get('/login', 'show')->name('login');
        Route::post('/login', 'login');

        Route::get('/forgot-password/reset/{token?}/{email?}', 'showResetPassword')->name('password.reset');
        Route::post('/forgot-password/reset/{token?}/{email?}', 'resetPassword');


        Route::get('/forgot-password', 'showResetPasswordRequest')->name('password.forgot')->middleware(['throttle:6,1']);
        Route::post('/forgot-password', 'resetPasswordRequest');

        Route::get('/confirm-password', 'showConfirmingPassword')->middleware(['auth', 'throttle:6,1']);
        Route::post('/confirm-password', 'confirmPassword')->middleware(['auth', 'throttle:6,1']);
    });
