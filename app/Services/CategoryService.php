<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class CategoryService
{
    protected $apiUrl;

    public function __construct()
    {
        // Mengambil URL dan API_KEY dari file .env
        $this->apiUrl = env('CATEGORY_API_URL', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/categories');
        $this->apiKey = env('API_KEY', 'secret'); // Mengambil API key
        $this->httpOptions = [
//            'verify' => 'C:\laragon\bin\php\php-8.3.12-Win32-vs16-x64\extras\ssl\cacert.pem',
            'verify' => false,
//            'verify' => 'C:\cacert.pem',
        ];
    }



    public function getAllCategories(): Collection
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey
        ])->get($this->apiUrl, [
            'page' => 0,
            'size' => 10
        ]);

        if (!$response->successful()) {
            dd($response->status(), $response->body()); // Debug status dan respons body
        }





        return collect($response->json());

    }

        // Mengambil kategori berdasarkan ID dari API Spring Boot
    public function getCategoryById($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey // Menambahkan API key pada header
        ])->get("{$this->apiUrl}/{$id}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    // Menambahkan kategori melalui API Spring Boot
    public function addCategory($name)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey // Menambahkan API key pada header
        ])->post($this->apiUrl, ['name' => $name]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    // Mengubah kategori berdasarkan ID di API Spring Boot
    public function updateCategory($id, $name)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey // Menambahkan API key pada header
        ])->put("{$this->apiUrl}/{$id}", ['name' => $name]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    // Menghapus kategori berdasarkan ID di API Spring Boot
    public function deleteCategory($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey // Menambahkan API key pada header
        ])->delete("{$this->apiUrl}/{$id}");

        return $response->successful();
    }
}
