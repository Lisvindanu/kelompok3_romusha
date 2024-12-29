<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Services\GenreService;
use Illuminate\Support\Facades\Log;

class GenreController extends Controller
{
    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 0);
        $size = $request->get('size', 10);

        $genres = $this->genreService->getAllGenres($page, $size);

        if ($genres === null) {
            return view('dashboard.genre-game.index', [
                'genres' => [],
                'error' => 'Failed to fetch genres from API'
            ]);
        }

        return view('dashboard.genre-game.index', ['genres' => $genres]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categoryId' => 'required|numeric'
        ]);

        $response = $this->genreService->addGenre([
            'name' => $validated['name'],
            'categoryId' => $validated['categoryId']
        ]);

        if ($response) {
            return redirect()->route('genres.index')
                ->with('success', 'Genre successfully added!');
        }

        return redirect()->back()
            ->with('error', 'Failed to add genre. Please try again.');
    }

    public function updateGenre(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categoryId' => 'required|numeric'
        ]);

        $response = $this->genreService->updateGenre($id, [
            'name' => $validated['name'],
            'categoryId' => $validated['categoryId']
        ]);

        if ($response) {
            return redirect()->route('genres.index')
                ->with('success', 'Genre successfully updated!');
        }

        return redirect()->back()
            ->with('error', 'Failed to update genre.');
    }

    public function deleteGenre($id)
    {
        if ($this->genreService->deleteGenre($id)) {
            return redirect()->route('genres.index')
                ->with('success', 'Genre successfully deleted!');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete genre.');
    }
}
