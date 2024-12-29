<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class GenreService
{
    protected $baseUrl;
    protected $httpOptions;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('SPRING_API_URL', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com'); // Menggunakan SPRING_API_URL untuk genre API
        $this->apiKey = env('API_KEY', 'secret'); // Mengambil API key

        $this->httpOptions = [
            'verify' => false, // Nonaktifkan verifikasi SSL (atau gunakan sertifikat)
        ];
    }

    public function addGenre($data)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
        ])->withOptions($this->httpOptions)
        ->post("{$this->baseUrl}/api/genres", $data);

        if ($response->successful()) {
            return $response->json(); // Mengembalikan data genre yang berhasil dibuat
        }

        return null; // Mengembalikan null jika request gagal
    }

    public function getGenreById($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey
        ])->withOptions($this->httpOptions)->get("{$this->baseUrl}/api/genres/{$id}");

        if ($response->successful()) {
            return $response->json(); // Return the genre data
        }

        return null; // Return null if the API request fails
    }

    public function getAllGenres()
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey
        ])->withOptions($this->httpOptions)->get("{$this->baseUrl}/api/genres");

        if ($response->successful()) {
            return collect($response->json()); // Return a collection of genres
        }

        return collect(); // Return an empty collection if the API request fails
    }

    public function updateGenre($id, $data)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
        ])->withOptions($this->httpOptions)->put("{$this->baseUrl}/api/genres/{$id}", $data);

        if ($response->successful()) {
            return $response->json(); // Return the updated genre data
        }

        return null; // Return null if the API request fails
    }

    public function deleteGenre($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey
        ])->withOptions($this->httpOptions)->delete("{$this->baseUrl}/api/genres/{$id}");

        if ($response->successful()) {
            return true; // Return true if deletion is successful
        }

        return false; // Return false if the API request fails
    }
}
