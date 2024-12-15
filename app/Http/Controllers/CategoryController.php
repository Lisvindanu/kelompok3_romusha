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
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // Ensures 'name' is unique in the 'categories' table
        ]);

        // Call service to add category
        $category = $this->categoryService->addCategory($validated['name']);

        if ($category) {
            return response()->json($category, 201);
        }

        return response()->json(['message' => 'Failed to create category'], 400);
    }


    // Mengubah kategori berdasarkan ID
    public function updateCategory($id, Request $request)
    {
        $name = $request->input('name');
        $category = $this->categoryService->updateCategory($id, $name);

        if ($category) {
            return response()->json($category, 200);
        }

        return response()->json(['message' => 'Failed to update category'], 400);
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard')->with('success', 'Kategori berhasil ditambahkan.');
    }

}
