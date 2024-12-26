<?php
namespace App\Services;
use App\Models\Category;

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
        // Ambil semua data kategori dari database
        return Category::all(); // Menggunakan Eloquent untuk mengambil semua data dari tabel 'categories'
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

//    public function addCategory($name)
//    {
//        $response = Http::withHeaders([
//            'X-Api-Key' => $this->apiKey, // Header API Key
//        ])->post($this->apiUrl, [
//            'name' => $name,
//        ]);
//
//        if ($response->successful()) {
//            return $response->json();
//        }
//
//        return null;
//    }


    public function addCategory($name)
    {
        // Mengirimkan permintaan POST untuk menambahkan kategori
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey, // Menyertakan API key di header
        ])->post($this->apiUrl, [
            'name' => $name, // Data yang dikirimkan untuk kategori
        ]);

        // Log raw response untuk debugging
        \Log::info('Raw API Response for Category: ', [
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json()
        ]);

        // Memeriksa apakah response sukses
        if ($response->successful()) {
            // Mengambil data JSON dari response
            $category = $response->json();

            // Logging hasil parse response untuk detail lebih lanjut
            \Log::info('Parsed Category response: ' . json_encode($category));

            // Mengambil ID dan nama kategori
            $categoryId = $category['id'] ?? null;
            $categoryName = $category['name'] ?? $name; // Default ke nama yang dikirim jika tidak ada dalam response

            // Memastikan nama kategori adalah string
            if (is_string($categoryName)) {
                // Menangani jika nama kategori dalam format JSON string
                $parsedName = json_decode($categoryName, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($parsedName['name'])) {
                    $categoryName = $parsedName['name'];
                }
            }

            return [
                'id' => $categoryId,
                'name' => $categoryName,
            ];
        }

        // Log jika API request gagal
        \Log::error('API request failed for Category', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        // Mengembalikan null jika gagal
        return null;
    }





    public function updateCategory($id, $name){
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey, // Header API Key
        ])->put("{$this->apiUrl}/{$id}", [
            'name' => $name,
        ]);

        if ($response->successful()) {
            return $response->json();
        }
        return null;
    }


    // Menghapus kategori berdasarkan ID di API Spring Boot
    public function deleteCategory($id)
    {
        $category = Category::find($id);  // Cari kategori berdasarkan ID
    
        if (!$category) {
            return false;  // Kategori tidak ditemukan
        }
    
        return $category->delete();  // Hapus kategori
    }
    
    
    
}
