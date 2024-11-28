<?php

use Illuminate\Support\Facades\Route;

// Route untuk halaman Home
Route::get('/', function () {
    return view('home');
});

// Route untuk halaman About
Route::get('/about', function () {
    return view('about');
});

// Route untuk halaman Game
Route::get('/games', function () {
    return view('games'); 
});

// Route untuk halaman 
Route::get('/consoles', function () {
    return view('consoles'); 
});

// Route untuk halaman Login
Route::get('/login', function () {
    return view('login.index'); 
});

// Route untuk halaman Register
Route::get('/register', function () {
    return view('register.index'); 
});
