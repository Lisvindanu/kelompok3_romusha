<?php

use App\Http\Controllers\Auth\AuthentikasiController;
use Illuminate\Support\Facades\Route;
Route::prefix('auth')->group(function () {
    Route::get('register', [AuthentikasiController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthentikasiController::class, 'login'])->name('auth.login');
    Route::post('verify-otp', [AuthentikasiController::class, 'verifyOtp'])->name('auth.verifyOtp');
});

Route::middleware('auth:api')->get('/user', [UserController::class, 'getUserData']);
Route::post('logout', [AuthentikasiController::class, 'logout'])->name('auth.logout');

