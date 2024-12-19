<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\Products\ProductController;
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

// Route untuk halaman Dashboard User
Route::get('/profile-users', function () {
    return view('profile-users.profile');
});

// Route untuk halaman Ubah Password Dashboard User
Route::get('/change-password', function () {
    return view('profile-users.change-password');
});

// Route untuk logout
Route::post('logout', [AuthentikasiController::class, 'logout'])->name('auth.logout');

// Route untuk halaman Lupa Password
Route::get('/forgot-password', function () {
    return view('forgot-password.index');
});
// Update untuk route show-reset-password
Route::get('/show-reset-password/{token}', [AuthentikasiController::class, 'showResetPasswordForm'])->name('auth.show-reset-password-form');

// Update untuk route reset-password
Route::post('/password-reset', [AuthentikasiController::class, 'resetPassword'])->name('auth.reset-password');





Route::post('/password-reset-request', [AuthentikasiController::class, 'requestPasswordReset'])->name('auth.password-reset-request');



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
//Route::post('/auth/login', [AuthentikasiController::class, 'login']);


//Route::post('/verify-otp', [AuthentikasiController::class, 'verifyOtp'])->name('auth.verifyOtp');

// Route untuk verify-otp
Route::post('/verify-otp', [AuthentikasiController::class, 'verifyOtp'])->name('auth.verifyOtp');


//Route untuk login with Google
Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);

Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);


// Category Routes
Route::prefix('categories')->group(function() {
    Route::get('/', [CategoryController::class, 'getAllCategories']); // Get all categories
    Route::get('{id}', [CategoryController::class, 'getCategoryById']); // Get category by ID
    Route::put('{id}', [CategoryController::class, 'updateCategory']); // Update category
    Route::delete('{id}', [CategoryController::class, 'deleteCategory']); // Delete category
    Route::get('{id}/edit', [CategoryController::class, 'editCategory'])->name('categories.edit'); // Edit category
    Route::post('/', [CategoryController::class, 'addCategory'])->name('categories.addCategories'); // Add category
});


// Genre Routes
Route::prefix('genres')->group(function() {
    Route::get('/', [GenreController::class, 'getAllGenres']); // Get all genres
    Route::get('{id}', [GenreController::class, 'getGenreById']); // Get genre by ID
    Route::put('{id}', [GenreController::class, 'updateGenre']); // Update genre
    Route::delete('{id}', [GenreController::class, 'deleteGenre']); // Delete genre
    Route::post('/genres', [GenreController::class, 'addGenre'])->name('genres.addGenres');

});


// Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'listProducts'])->name('products.index');    
    Route::get('/{id}', [ProductController::class, 'getProduct'])->name('products.show')
        ->where('id', '[0-9]+'); // Ensure 'id' is numeric
    Route::post('/', [ProductController::class, 'create'])->name('products.create');
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update')
        ->where('id', '[0-9]+'); // Ensure 'id' is numeric
    Route::delete('/{id}', [ProductController::class, 'delete'])->name('products.delete')
        ->where('id', '[0-9]+'); // Ensure 'id' is numeric
});


// // Rute untuk menampilkan daftar produk
// Route::get('/products', [ProductController::class, 'listProducts'])->name('products.index');

// // Rute untuk menampilkan detail produk
// Route::get('/products/{id}', [ProductController::class, 'getProduct'])->name('products.show');

// // Rute untuk menambahkan produk baru
// Route::post('/products', [ProductController::class, 'create'])->name('products.create');

// // Rute untuk memperbarui produk
// Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

// // Rute untuk menghapus produk
// Route::delete('/products/{id}', [ProductController::class, 'delete'])->name('products.delete');
// //Route::post('/products', [ProductController::class, 'create']);
// //Route::put('/products/{id}', [ProductController::class, 'update']);
// //Route::get('/products/{id}', [ProductController::class, 'getProduct']);
// //Route::get('/products', [ProductController::class, 'listProducts']);
// //Route::delete('/products/{id}', [ProductController::class, 'delete']);
