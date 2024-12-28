<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\GenreService;
use App\Http\Controllers\Auth\AuthentikasiController;

class DashboardController extends Controller
{
    protected $authController;
    protected $categoryService;
    protected $genreService;

    public function __construct(AuthentikasiController $authController, CategoryService $categoryService, GenreService $genreService)
    {
        $this->authController = $authController;
        $this->categoryService = $categoryService;
        $this->genreService = $genreService;
    }


    public function index(Request $request)
    {
        if (!session('user')) {
            return redirect()->route('login');
        }

        $token = session('user');

        // Ambil data user menggunakan token
        $userData = $this->authController->getUserData($token);

        // Pastikan data userData terdefinisi dengan baik
        if (empty($userData)) {
            return redirect()->route('login')->withErrors(['error' => 'User data not found.']);
        }

        // Fetch categories and genres
        $categories = collect($this->categoryService->getAllCategories());
        $genres = collect($this->genreService->getAllGenres());

        // Pass userData ke view
        return view('dashboard.index', compact('userData', 'categories', 'genres'));
    }


}
