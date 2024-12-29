<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenreController extends Controller
{
    protected $springBootApiUrl = 'http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/genres';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('API_KEY', 'secret');
    }

    protected function callApi($method, $url, $data = [])
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
            ])->{$method}($url, $data);

            if ($response->successful()) {
                Log::info('API Response', ['url' => $url, 'data' => $response->json()]);
                return $response->json();
            }

            Log::error('API Error', ['url' => $url, 'response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('API Exception', ['url' => $url, 'exception' => $e->getMessage()]);
            return null;
        }
    }

    public function index()
    {
        $errorMessage = null;

        // Mengambil data genres dari API
        $genres = $this->callApi('get', $this->springBootApiUrl);

        if (!is_array($genres)) {
            $genres = [];
            $errorMessage = 'Gagal mengambil data genre dari API.';
        } else {
            $genres = collect($genres)->map(function ($genre) {
                return [
                    'id' => $genre['id'] ?? null,
                    'name' => $genre['name'] ?? 'Tidak diketahui',
                ];
            })->toArray();
        }

        return view('dashboard.genre-game.index', compact('genres'))
            ->with('error', $errorMessage);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $response = $this->callApi('post', $this->springBootApiUrl, $validated);

        if ($response) {
            return redirect()->route('genres.index')->with('success', 'Genre berhasil ditambahkan!');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan genre. Silakan coba lagi.');
    }

    public function updateGenre(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $response = $this->callApi('put', "{$this->springBootApiUrl}/{$id}", $validated);
    
        if ($response) {
            return redirect()->route('genres.index')->with('success', 'Genre berhasil diperbarui!');
        }
    
        return redirect()->back()->with('error', 'Gagal memperbarui genre.');
    }
    
    
    public function deleteGenre($id)
    {
        $response = $this->callApi('delete', "{$this->springBootApiUrl}/{$id}");

        if ($response) {
            return redirect()->route('genres.index')->with('success', 'Genre berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Gagal menghapus genre.');
    }

    public function getGenreById($id)
    {
        $genre = $this->callApi('get', "{$this->springBootApiUrl}/{$id}");

        if ($genre) {
            return view('genres.edit', compact('genre'));
        }

        return redirect()->route('genres.index')->with('error', 'Genre tidak ditemukan.');
    }
}
