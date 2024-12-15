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
//            'verify' => 'C:\laragon\bin\php\php-8.3.12-Win32-vs16-x64\extras\ssl\cacert.pem',
            'verify' => false,
//            'verify' => 'C:\cacert.pem',

        ];
    }

    public function addGenre($data)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey // Menambahkan API key pada header
        ])->withOptions($this->httpOptions)->post("{$this->baseUrl}/api/genres", $data);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function getGenreById($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey // Menambahkan API key pada header
        ])->withOptions($this->httpOptions)->get("{$this->baseUrl}/api/genres/{$id}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function getAllGenres()
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey
        ])->withOptions($this->httpOptions)->get("{$this->baseUrl}/api/genres");

        // Ensure that the response is parsed as a collection of objects
        if ($response->successful()) {
            $genres = $response->json();
            return collect($genres); // Convert the array into a collection
        }

        return collect(); // Return an empty collection if the API call fails
    }

    public function updateGenre($id, $data)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey // Menambahkan API key pada header
        ])->withOptions($this->httpOptions)->put("{$this->baseUrl}/api/genres/{$id}", $data);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function deleteGenre($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey // Menambahkan API key pada header
        ])->withOptions($this->httpOptions)->delete("{$this->baseUrl}/api/genres/{$id}");

        if ($response->successful()) {
            return true;
        }

        return false;
    }
}
