<?php

use App\Http\Controllers\Auth\AuthentikasiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('register', [AuthentikasiController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthentikasiController::class, 'login'])->name('auth.login');
    Route::post('verify-otp', [AuthentikasiController::class, 'verifyOtp'])->name('auth.verifyOtp');
});

// routes/api.php
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'getAllCategories']);
    Route::get('{id}', [CategoryController::class, 'getCategoryById']);
    Route::put('{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('{id}', [CategoryController::class, 'deleteCategory']);
});

Route::prefix('genres')->group(function () {
    Route::get('/', [GenreController::class, 'getAllGenres']);
    Route::get('{id}', [GenreController::class, 'getGenreById']);
    Route::put('{id}', [GenreController::class, 'updateGenre']);
    Route::delete('{id}', [GenreController::class, 'deleteGenre']);
});


Route::middleware('auth:api')->get('/user', [UserController::class, 'getUserData']);
Route::post('logout', [AuthentikasiController::class, 'logout'])->name('auth.logout');

Route::post('/api/inventory/add', [InventoryController::class, 'addToInventory']);
