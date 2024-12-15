<?php
namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->httpOptions = [
//            'verify' => 'C:\laragon\bin\php\php-8.3.12-Win32-vs16-x64\extras\ssl\cacert.pem'

            'verify' => false,
//            'verify' => 'C:\cacert.pem',

        ];
    }




    // Mendapatkan semua kategori
    public function getAllCategories()
    {
        $categories = $this->categoryService->getAllCategories();

        if ($categories) {
            return response()->json($categories, 200);
        }

        return response()->json(['message' => 'Failed to fetch categories'], 400);
    }

    // Mendapatkan kategori berdasarkan ID
    public function getCategoryById($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        if ($category) {
            return response()->json($category, 200);
        }

        return response()->json(['message' => 'Category not found'], 404);
    }

    // Menambahkan kategori baru
    public function addCategory(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Kirim data ke API melalui CategoryService
        $category = $this->categoryService->addCategory($validated['name']);

        if ($category) {
            return response()->json([
                'message' => 'Kategori berhasil ditambahkan.',
                'data' => $category,
            ], 201);
        }

        return response()->json([
            'message' => 'Gagal menambahkan kategori.',
        ], 400);
    }



    public function updateCategory(Request $request, $id)
    {
        // Validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Kirim data ke API melalui CategoryService
        $category = $this->categoryService->updateCategory($id, $validated['name']);

        if ($category) {
            return response()->json([
                'message' => 'Kategori berhasil diperbarui.',
                'data' => $category,
            ], 200);
        }

        return response()->json([
            'message' => 'Gagal memperbarui kategori.',
        ], 400);
    }


    // Menghapus kategori berdasarkan ID
    public function deleteCategory($id)
    {
        $deleted = $this->categoryService->deleteCategory($id);

        if ($deleted) {
            return response()->json(['message' => 'Category deleted successfully'], 204);
        }

        return response()->json(['message' => 'Failed to delete category'], 400);
    }

    public function editCategory($id)
    {
        // Mengambil data kategori berdasarkan ID
        $category = $this->categoryService->getCategoryById($id);

        if ($category) {
            return view('category.edit', compact('category'));
        }

        return redirect()->route('categories.index')->with('error', 'Kategori tidak ditemukan.');
    }


}
