<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\AuthentikasiController;
use App\Http\Controllers\DashboardController;



// Route untuk halaman Home
Route::get('/', function () {
    return view('home');
});

// Route untuk halaman About
Route::get('/about', function () {
    return view('about');
});

// Route untuk halaman Games
Route::get('/games', function () {
    return view('games');
});

// Route untuk halaman Detail Game
Route::get('/detail-game', function () {
    return view('detail-game');
});

// Route untuk halaman Consoles
Route::get('/consoles', function () {
    return view('consoles');
});

// Route untuk halaman Detail Console
Route::get('/detail-console', function () {
    return view('detail-console');
});

// Route untuk halaman Keranjang
Route::get('/cart', function () {
    return view('cart');
});

// Route untuk halaman Login
Route::get('/login', function () {
    return view('login.index');
})->name('login');

// Route untuk logout
Route::post('logout', [AuthentikasiController::class, 'logout'])->name('auth.logout');

// Route untuk halaman Lupa Password
Route::get('/forgot-password', function () {
    return view('forgot-password.index');
});

// Route untuk halaman request reset password
Route::get('/password-reset-request', function () {

});

// Route untuk halaman reset password
Route::get('/reset-password', function () {
    return view('forgot-password.reset-password');
});

// Route untuk halaman Register
Route::get('/register', function () {
    return view('register.index');
});



// Route untuk halaman Dashboard
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk halaman Dashboard (tanpa auth middleware untuk percobaan)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::get('/otp', [AuthentikasiController::class, 'showOtpForm'])->name('auth.otp');





// Route untuk register form submission
Route::post('/auth/register', [AuthentikasiController::class, 'register'])->name('auth.register');


Route::post('/auth/login', [AuthentikasiController::class, 'login'])->name('auth.login');

Route::post('/verify-otp', [AuthentikasiController::class, 'verifyOtp'])->name('auth.verifyOtp');



//Route untuk login with Google
Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);

Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);



