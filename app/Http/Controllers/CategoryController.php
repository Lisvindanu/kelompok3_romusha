<?php
namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Models\Category; // Pastikan ini ada
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
        // Ambil data kategori dari service
        $categories = $this->categoryService->getAllCategories();
    
        // Kirim data kategori ke view
        return view('categories.index', ['categories' => $categories]);
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
    // Validasi input
    $validated = $request->validate([
        'name' => 'required|unique:categories,name|max:255', // Validasi nama kategori
    ]);

    try {
        // Menambah kategori baru ke database
        $category = new Category();
        $category->name = $request->name;
        $category->save();

        // Menyimpan session sukses dan redirect kembali
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    } catch (\Exception $e) {
        // Menangani kesalahan dan mengirimkan pesan error
        return redirect()->back()->with('error', 'Terjadi kesalahan, gagal menambahkan kategori.');
    }
}






public function updateCategory(Request $request, $id)
{
    try {
        // Cari kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Perbarui nama kategori
        $category->name = $request->input('name');
        $category->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Redirect kembali jika kategori tidak ditemukan
        return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
    } catch (\Exception $e) {
        // Redirect kembali jika terjadi error lain
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kategori.');
    }
}



    // Menghapus kategori berdasarkan ID
    public function deleteCategory($id)
    {
        try {
            // Cari kategori berdasarkan ID
            $category = Category::findOrFail($id);
    
            // Hapus kategori
            $category->delete();
    
            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Redirect kembali jika kategori tidak ditemukan
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        } catch (\Exception $e) {
            // Redirect kembali jika terjadi error lain
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }

    public function editCategory($id)
    {
        // Temukan kategori berdasarkan ID
        $category = Category::findOrFail($id);
    
        // Kirim data kategori ke view untuk diedit
        return view('categories.edit', compact('category'));
    }
    


}
