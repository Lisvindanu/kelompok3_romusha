<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title'=>'HOME']);
});
Route::get('/about', function () {
    return view('about');
});

// Route untuk halaman login
Route::get('/login', function () {
    return view('login.index'); 
});

// Route untuk halaman Register
Route::get('/register', function () {
    return view('register.index'); 
});