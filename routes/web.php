<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\Products\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\AuthentikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

// Public Pages Routes
Route::get('/', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/games', function () {
    return view('games');
});
Route::get('/detail-game', function () {
    return view('detail-game');
});
Route::get('/consoles', function () {
    return view('consoles');
});
Route::get('/detail-console', function () {
    return view('detail-console');
});
Route::get('/ewallet', function () {
    return view('ewallet');
});
Route::get('/detail-ewallet', function () {
    return view('detail-ewallet');
});
Route::get('/cart', function () {
    return view('cart');
});
Route::get('/payment', function () {
    return view('payment.form-payment');
});

// Authentication Routes
Route::get('/login', function () {
    return view('login.index');
})->name('login');
Route::get('/register', function () {
    return view('register.index');
});
Route::get('/forgot-password', function () {
    return view('forgot-password.index');
});
Route::get('/show-reset-password/{token}', [AuthentikasiController::class, 'showResetPasswordForm'])
    ->name('auth.show-reset-password-form');
Route::get('/otp', [AuthentikasiController::class, 'showOtpForm'])->name('auth.otp');

Route::post('/auth/register', [AuthentikasiController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [AuthentikasiController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthentikasiController::class, 'logout'])->name('auth.logout');
Route::post('/verify-otp', [AuthentikasiController::class, 'verifyOtp'])->name('auth.verifyOtp');
Route::post('/password-reset', [AuthentikasiController::class, 'resetPassword'])->name('auth.reset-password');
Route::post('/password-reset-request', [AuthentikasiController::class, 'requestPasswordReset'])
    ->name('auth.password-reset-request');

// Google Authentication Routes
Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);

// User Profile Routes
Route::get('/profile-users', function () {
    return view('profile-users.profile');
});
Route::get('/change-password', function () {
    return view('profile-users.change-password');
});
Route::get('/history-order', function () {
    return view('profile-users.history-order');
});

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Category Routes
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'getAllCategories'])->name('categories.index');
    Route::get('{id}', [CategoryController::class, 'getCategoryById']);
    Route::get('{id}/edit', [CategoryController::class, 'editCategory'])->name('categories.edit');
    Route::put('{id}', [CategoryController::class, 'updateCategory'])->name('categories.update');
    Route::delete('{id}', [CategoryController::class, 'deleteCategory'])->name('categories.delete');
    Route::post('/', [CategoryController::class, 'addCategory'])->name('categories.addCategories');
});

// Genre Routes
Route::prefix('genres')->group(function () {
    Route::get('/', [GenreController::class, 'index'])->name('genres.index');
    Route::post('/', [GenreController::class, 'store'])->name('genres.store');
    Route::put('/{id}', [GenreController::class, 'updateGenre'])->name('genres.update');
    Route::delete('/{id}', [GenreController::class, 'deleteGenre'])->name('genres.destroy');
});

// Dashboard Products Routes
Route::prefix('dashboard/products')->group(function () {
    Route::get('/', [ProductController::class, 'listProductsByCategory'])->name('dashboard.products.index');
    Route::get('/create', [ProductController::class, 'createForm'])->name('dashboard.products.createForm');
    Route::get('/edit/{id}', [ProductController::class, 'updateForm'])->name('dashboard.products.updateForm');
    Route::get('/show-product/{id}', [ProductController::class, 'getProductShow'])->name('dashboard.products.show');
<<<<<<< Updated upstream

=======
    
>>>>>>> Stashed changes
    // API Actions for Dashboard
    Route::post('/', [ProductController::class, 'create'])->name('dashboard.products.create');
    Route::put('/{id}', [ProductController::class, 'update'])->name('dashboard.products.update');
    Route::delete('/{id}', [ProductController::class, 'delete'])->name('dashboard.products.delete');
});

// Public API Products Routes
Route::prefix('api/products')->group(function () {
    Route::get('/', [ProductController::class, 'listProducts'])->name('api.products.index');
    Route::get('/{id}', [ProductController::class, 'getProduct'])->name('api.products.show');
    Route::post('/', [ProductController::class, 'create'])->name('api.products.create');
    Route::put('/{id}', [ProductController::class, 'update'])->name('api.products.update');
    Route::delete('/{id}', [ProductController::class, 'delete'])->name('api.products.delete');
});

// Genre Game Dashboard Routes
Route::get('/dashboard/genre-game', [GenreController::class, 'index'])->name('dashboard.genre-game');

// Product Game Dashboard Routes
Route::prefix('dashboard/product-game')->group(function () {
    Route::get('/', function () {
        return view('dashboard.product-game.index');
    });
    Route::get('/create', function () {
        return view('dashboard.product-game.create');
    });
    Route::get('/show', function () {
        return view('dashboard.product-game.show');
    });
    Route::get('/edit', function () {
        return view('dashboard.product-game.edit');
    });
});

// Product Console Dashboard Routes
Route::prefix('dashboard/product-console')->group(function () {
    Route::get('/', function () {
        return view('dashboard.product-console.index');
    });
    Route::get('/create', function () {
        return view('dashboard.product-console.create');
    });
    Route::get('/show', function () {
        return view('dashboard.product-console.show');
    });
    Route::get('/edit', function () {
        return view('dashboard.product-console.edit');
    });
});
<<<<<<< Updated upstream
=======



Route::get('/', [HomeController::class, 'index']);
>>>>>>> Stashed changes
