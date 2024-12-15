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

//    public function index(Request $request)
//    {
//        if (!session('user')) {
//            return redirect()->route('login');
//        }
//
//        $token = session('user');
//        $userData = $this->authController->getUserData($token);
//
//        // Fetch categories and genres from the services
//        $categories = collect($this->categoryService->getAllCategories());
//        $genres = collect($this->genreService->getAllGenres());
//
//        return view('dashboard.index', compact('userData', 'categories', 'genres'));
//    }


    public function index(Request $request)
    {
        if (!session('user')) {
            return redirect()->route('login');
        }

        $token = session('user');
        $userData = $this->authController->getUserData($token);

        // Fetch categories and genres
        $categories = collect($this->categoryService->getAllCategories());
        $genres = collect($this->genreService->getAllGenres());




        return view('dashboard.index', compact('userData', 'categories', 'genres'));
    }

}
