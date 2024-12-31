<?php

use App\Http\Controllers\InventoryController;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\RoleAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Auth\AuthentikasiController;

// Public Pages Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
});
Route::get('/product/{id}', [HomeController::class, 'getProductShow'])->name('detail-product');
Route::get('/games', [HomeController::class, 'getGameProducts'])->name('products.game');
Route::get('/consoles', [HomeController::class, 'getConsoleProducts'])->name('products.console');
Route::get('/ewallet', [HomeController::class, 'getEVoucherProducts'])->name('products.ewallet');

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
Route::get('/profile-users', [AuthentikasiController::class, 'showProfileForm'])
    ->middleware([CheckUser::class]);

Route::post('/update-profile', [AuthentikasiController::class, 'updateProfile'])
    ->middleware([CheckUser::class])
    ->name('update.profile');

Route::get('/change-password', function () {
    return view('profile-users.change-password');
});
//Route::get('/history-order', [AuthentikasiController::class, 'showOrderHistory'])
//    ->middleware([CheckUser::class]);

Route::get('/history-order', [InventoryController::class, 'getOrderHistory'])
    ->middleware([CheckUser::class])  // Gunakan CheckUser middleware sesuai kebutuhan
    ->name('history-order');

// Dashboard Routes
Route::middleware([CheckUser::class, RoleAccess::class.':ADMIN'])->group(function() {
    // Dashboard Main Route
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

        // API Actions for Dashboard
        Route::post('/', [ProductController::class, 'create'])->name('dashboard.products.create');
        Route::put('/{id}', [ProductController::class, 'update'])->name('dashboard.products.update');
        Route::delete('/{id}', [ProductController::class, 'delete'])->name('dashboard.products.delete');
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

    // Product Console Dashboard Routes (Duplicated in original, keeping for exact match)
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
});

// Public API Products Routes
Route::prefix('api/products')->group(function () {
    Route::get('/', [ProductController::class, 'listProducts'])->name('api.products.index');
    Route::get('/{id}', [ProductController::class, 'getProduct'])->name('api.products.show');
    Route::post('/', [ProductController::class, 'create'])->name('api.products.create');
    Route::put('/{id}', [ProductController::class, 'update'])->name('api.products.update');
    Route::delete('/{id}', [ProductController::class, 'delete'])->name('api.products.delete');
});

Route::middleware([CheckUser::class])->group(function () {
    Route::get('/change-password', [AuthentikasiController::class, 'showChangePasswordForm'])->name('change.password.form');
    Route::post('/update-password', [AuthentikasiController::class, 'updatePassword'])->name('update.password');
});

Route::get('/unauthorized', function () {
    return view('unauthorized.index');
})->name('unauthorized');

Route::post('/api/inventory/use', [InventoryController::class, 'useInventoryItem'])->middleware('auth');

//Route::post('/api/inventory/add', [InventoryController::class, 'addToInventory'])
//    ->middleware([CheckUser::class]);

Route::post('/api/inventory/add', [InventoryController::class, 'addToInventory']);


