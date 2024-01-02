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

Route::controller(\App\Http\Controllers\Login::class)->group(function () {
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'login');

    Route::get('/forgot-password/reset/{token?}', 'showResetPassword')->name('password.reset');
    Route::post('/forgot-password/reset/{token?}', 'resetPassword');

    Route::get('/forgot-password', 'showResetPasswordRequest');
    Route::post('/forgot-password', 'resetPasswordRequest');

    Route::get('/confirm-password', 'showConfirmingPassword')->middleware(['auth', 'throttle:6,1']);
    Route::post('/confirm-password', 'confirmPassword')->middleware(['auth', 'throttle:6,1']);
});
