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


        // Cek token di sesi
        if (!session('user')) {
            return redirect()->route('login');
        }

        $token = session('user');


        try {
            $userData = $this->authController->getUserData($token);


            if (empty($userData)) {
                return redirect()->route('login')->withErrors(['error' => 'User data not found.']);
            }

            $categories = $this->categoryService->getAllCategories();
            $genres = $this->genreService->getAllGenres();


            return view('dashboard.index', compact('userData', 'categories', 'genres'));

        } catch (\Exception $e) {
            dd([
                'error_message' => $e->getMessage(),
            ]);
        }

    }


}
