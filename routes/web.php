<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title'=>'HOME']);
});
Route::get('/about', function () {
    return view('about', ['nama' =>'RetroGame-hub'],['title' =>'About']);
});