<?php
namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
            return 'Categories retrieved successfully';  // Mengembalikan string sebagai response
        }
    
        return 'Failed to fetch categories';
    }
    

    // Mendapatkan kategori berdasarkan ID
    public function getCategoryById($id)
    {
        $category = $this->categoryService->getCategoryById($id);
    
        if ($category) {
            return 'Category found';  // Mengembalikan string
        }
    
        return 'Category not found';
    }
    

//    public function addCategory(Request $request)
//    {
//        // Validasi data input
//        $validated = $request->validate([
//            'name' => 'required|string|max:255',
//        ]);
//
//        try {
//            // Kirim data ke API melalui CategoryService
//            $category = $this->categoryService->addCategory($validated['name']);
//
//            if ($category) {
//                return response()->json([
//                    'message' => 'Kategori berhasil ditambahkan.',
//                    'data' => $category,
//                ], 201);
//            }
//
//            return response()->json([
//                'message' => 'Gagal menambahkan kategori.',
//            ], 400);
//        } catch (\Exception $e) {
//            // Log the full exception for debugging
//            \Log::error('Category Add Error: ' . $e->getMessage());
//
//            return response()->json([
//                'message' => 'Gagal menambahkan kategori: ' . $e->getMessage(),
//            ], 400);
//        }
//    }

    public function addCategory(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            // Kirim data ke API melalui CategoryService
            $category = $this->categoryService->addCategory($validated['name']);

            if ($category) {
                return 'Category added successfully';  // Mengembalikan response dalam bentuk string
            }

            return 'Failed to add category';
        } catch (\Exception $e) {
            \Log::error('Category Add Error: ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $validated['name']
            ]);

            return 'Failed to add category: ' . $e->getMessage();  // Mengembalikan pesan error sebagai string
        }
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
            return 'Category updated successfully';  // Mengembalikan string
        }
    
        return 'Failed to update category';
    }
    



    // Menghapus kategori berdasarkan ID
    public function deleteCategory($id)
    {
        $deleted = $this->categoryService->deleteCategory($id);
    
        if ($deleted) {
            return 'Category deleted successfully';  // Mengembalikan string
        }
    
        return 'Failed to delete category';
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
