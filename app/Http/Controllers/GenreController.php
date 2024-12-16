<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GenreService;
use Illuminate\Support\Facades\Http;
use App\Logging\Log; // Import kelas Log yang kita buat

class GenreController extends Controller
{
    protected $genreService;
    protected $baseUrl;
    protected $apiKey;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
        $this->baseUrl = env('SPRING_API_URL', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com');
        $this->apiKey = env('API_KEY', 'secret');
        $this->httpOptions = [
            'verify' => false,
        ];
    }

    public function addGenre(Request $request)
    {
        Log::info('addGenre function called');
        Log::info('Request data', ['request' => $request->all()]);

        // Validasi parameter
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
            ]);
            Log::info('Validation passed', $validated);
        } catch (\Exception $e) {
            Log::error('Validation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Validation failed', 'message' => $e->getMessage()], 400);
        }

        // Cek apakah category_id ada di tabel categories
        $categoryExists = \DB::table('categories')->where('id', $validated['category_id'])->exists();
        if (!$categoryExists) {
            Log::error('Category ID does not exist', ['category_id' => $validated['category_id']]);
            return response()->json(['error' => 'Category ID does not exist', 'category_id' => $validated['category_id']], 400);
        }

        Log::info('Category ID exists', ['category_id' => $validated['category_id']]);

        // Data yang akan dikirim ke API
        $data = [
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
        ];

        Log::info('Data prepared for API request', $data);

        try {
            Log::info('Sending request to API', ['url' => $this->baseUrl]);

            // Mengirim request POST ke API eksternal
            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
            ])->withOptions($this->httpOptions)
                ->post("{$this->baseUrl}/api/genres", $data);

            Log::info('Response received', ['status' => $response->status(), 'body' => $response->body()]);

            // Memeriksa apakah request berhasil
            if ($response->successful()) {
                return response()->json($response->json(), 201);
            } else {
                Log::error('Failed to create genre', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['error' => 'Failed to create genre', 'details' => $response->body()], $response->status());
            }

        } catch (\Exception $e) {
            Log::error('Exception caught', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
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
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categoryId' => 'required|exists:categories,id',
        ]);

        // Prepare data for updating the genre
        $data = [
            'name' => $validated['name'],
            'categoryId' => $validated['categoryId'],
        ];

        // Call service to update the genre
        $response = $this->genreService->updateGenre($id, $data);

        if ($response) {
            return response()->json($response, 200); // Return the updated genre with a 200 status
        }

        return response()->json(['error' => 'Failed to update genre'], 500); // Error response if the update fails
    }


    public function deleteGenre($id)
    {
        $response = $this->genreService->deleteGenre($id);

        if ($response) {
            return response()->json(['message' => 'Genre deleted successfully'], 204);
        }

        return response()->json(['error' => 'Failed to delete genre'], 500);
    }



}
