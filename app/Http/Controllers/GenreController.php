<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GenreService;

class GenreController extends Controller
{
    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
        $this->httpOptions = [
//            'verify' => 'C:\laragon\bin\php\php-8.3.12-Win32-vs16-x64\extras\ssl\cacert.pem',
            'verify' => false,
//            'verify' => 'C:\cacert.pem',

        ];
    }

    public function addGenre(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Validate genre name
            'categoryId' => 'required|exists:categories,id', // Ensure the category ID exists in the 'categories' table
        ]);

        // Prepare data to pass to the service
        $data = [
            'name' => $validated['name'],
            'categoryId' => $validated['categoryId'],
        ];

        // Call service to add genre
        $response = $this->genreService->addGenre($data);

        if ($response) {
            return response()->json($response, 201);
        }

        return response()->json(['error' => 'Failed to create genre'], 500);
    }


    public function getGenreById($id)
    {
        $response = $this->genreService->getGenreById($id);

        if ($response) {
            return response()->json($response, 200);
        }

        return response()->json(['error' => 'Genre not found'], 404);
    }

    public function getAllGenres()
    {
        $response = $this->genreService->getAllGenres();

        if ($response) {
            return response()->json($response, 200);
        }

        return response()->json(['error' => 'Failed to fetch genres'], 500);
    }

    public function updateGenre(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'categoryId' => $request->categoryId,
        ];

        $response = $this->genreService->updateGenre($id, $data);

        if ($response) {
            return response()->json($response, 200);
        }

        return response()->json(['error' => 'Failed to update genre'], 500);
    }

    public function deleteGenre($id)
    {
        $response = $this->genreService->deleteGenre($id);

        if ($response) {
            return response()->json(['message' => 'Genre deleted successfully'], 204);
        }

        return response()->json(['error' => 'Failed to delete genre'], 500);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $genre = Genre::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Genre berhasil ditambahkan.');
    }

}
