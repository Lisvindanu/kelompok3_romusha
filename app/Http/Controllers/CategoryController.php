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

            $categories = json_decode($response->body(), true);

            // Normalize the categories
            $categories = array_map(function ($category) {
                // Check if the name field is a JSON string
                if (isset($category['name']) && is_string($category['name'])) {
                    $decodedName = json_decode($category['name'], true);

                    // If successfully decoded, replace name with the decoded value
                    if (json_last_error() === JSON_ERROR_NONE && isset($decodedName['name'])) {
                        $category['name'] = $decodedName['name'];
                    }
                }
                return $category;
            }, $categories ?? []);

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
            ])->withBody($validated['name'], 'text/plain') // Send raw string in the body
            ->post($this->springBootApiUrl);

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
            ])->withBody($validated['name'], 'text/plain') // Send raw string in the body
            ->put("{$this->springBootApiUrl}/{$id}");

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
