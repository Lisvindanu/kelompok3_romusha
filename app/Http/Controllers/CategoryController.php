<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    protected $springBootApiUrl = 'http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/categories';

    // Mendapatkan semua kategori
    public function getAllCategories()
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => env('API_KEY', 'secret'),
            ])->get($this->springBootApiUrl);
    
            // Ensure categories is always an array
            $categories = [];
            if ($response->successful()) {
                $rawCategories = json_decode($response->body(), true);
    
                // Check if the API response is an array
                if (is_array($rawCategories)) {
                    // Normalize categories to handle valid and stringified JSON
                    $categories = array_map(function ($item) {
                        // Decode if item is a JSON string
                        if (is_string($item)) {
                            $decoded = json_decode($item, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                return $decoded; // Return decoded object
                            }
                        }
    
                        // Return as-is if already valid
                        return $item;
                    }, $rawCategories);
                }
            }
    
            return view('categories.index', ['categories' => $categories]);
        } catch (\Exception $e) {
            return view('categories.index', ['categories' => []])
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    

    // Menambahkan kategori
    public function addCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            $response = Http::withHeaders([
                'X-Api-Key' => env('API_KEY', 'secret'),
            ])->post($this->springBootApiUrl, [
                'name' => $validated['name'],
            ]);

            // Decode response for debugging or logging (optional)
            $category = json_decode($response->body(), true);

            if ($response->successful()) {
                return redirect()->route('categories.index')
                    ->with('success', 'Kategori berhasil ditambahkan!');
            }

            return redirect()->back()
                ->with('error', 'Gagal menambahkan kategori: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Mengupdate kategori
    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            $response = Http::withHeaders([
                'X-Api-Key' => env('API_KEY', 'secret'),
            ])->put("{$this->springBootApiUrl}/{$id}", [
                'name' => $validated['name'],
            ]);

            if ($response->successful()) {
                return redirect()->route('categories.index')
                    ->with('success', 'Kategori berhasil diperbarui!');
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui kategori: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menghapus kategori
    public function deleteCategory($id)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => env('API_KEY', 'secret'),
            ])->delete("{$this->springBootApiUrl}/{$id}");

            if ($response->successful()) {
                return redirect()->route('categories.index')
                    ->with('success', 'Kategori berhasil dihapus!');
            }

            return redirect()->route('categories.index')
                ->with('error', 'Gagal menghapus kategori: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->route('categories.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Mendapatkan kategori berdasarkan ID
    public function getCategoryById($id)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => env('API_KEY', 'secret'),
            ])->get("{$this->springBootApiUrl}/{$id}");

            $category = json_decode($response->body(), true);

            if (is_array($category)) {
                return view('categories.edit', ['category' => $category]);
            }

            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menampilkan form edit kategori
    public function editCategory($id)
    {
        return $this->getCategoryById($id);
    }
}
