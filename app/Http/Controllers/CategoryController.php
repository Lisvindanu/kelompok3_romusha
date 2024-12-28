<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    protected $springBootApiUrl = 'http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/categories';

    // Menambahkan kategori
    public function addCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            $response = Http::post($this->springBootApiUrl, [
                'name' => $validated['name'],
            ]);

            if ($response->successful()) {
                return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
            }

            return redirect()->back()->with('error', 'Gagal menambahkan kategori.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Mengupdate kategori
    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            $response = Http::put("{$this->springBootApiUrl}/{$id}", [
                'name' => $validated['name'],
            ]);

            if ($response->successful()) {
                return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
            }

            return redirect()->back()->with('error', 'Gagal memperbarui kategori.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menghapus kategori
    public function deleteCategory($id)
    {
        try {
            $response = Http::delete("{$this->springBootApiUrl}/{$id}");

            if ($response->successful()) {
                return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus kategori.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Mendapatkan semua kategori
    public function getAllCategories()
    {
        try {
            $response = Http::get('http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/categories');

            if ($response->successful()) {
                $categories = $response->json();
                return view('categories.index', ['categories' => $categories]);
            }

            return view('categories.index', ['categories' => []])
                ->with('error', 'Failed to fetch categories.');
        } catch (\Exception $e) {
            return view('categories.index', ['categories' => []])
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // Mendapatkan kategori berdasarkan ID
    public function getCategoryById($id)
    {
        try {
            $response = Http::get("{$this->springBootApiUrl}/{$id}");

            if ($response->successful()) {
                $category = $response->json();
                return view('categories.edit', ['category' => $category]);
            }

            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menampilkan form edit kategori
    public function editCategory($id)
    {
        return $this->getCategoryById($id);
    }
}
