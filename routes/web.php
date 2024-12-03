<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;


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
Route::get('/keranjang', function () {
    return view('keranjang'); 
});

// Route untuk halaman Login
Route::get('/login', function () {
    return view('login.index'); 
});

// Route untuk halaman Register
Route::get('/register', function () {
    return view('register.index'); 
});

// Route untuk halaman Dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
});

//Route untuk login with Google
Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);

Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);
