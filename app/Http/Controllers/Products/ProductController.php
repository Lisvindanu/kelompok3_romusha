<?php

namespace App\Http\Controllers\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    protected $springBootApiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products';

    // Function to create a product
    public function create(Request $request)
    {
        // Validasi input data yang diterima (name, price, quantity, category_id, genre_id, image)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'genre_id' => 'nullable|exists:genres,id',
            'image_url' => 'nullable|url',
        ]);

        // Ambil data dari request
        $name = $request->input('name');
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $categoryId = $request->input('category_id');
        $genreId = $request->input('genre_id', null);  // Genre ID opsional
        $imageUrl = $request->input('image_url', null);

        $data = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'category_id' => $categoryId,
            'genre_id' => $genreId,
            'image_url' => $imageUrl,
        ];

        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->post($this->springBootApiUrl, $data);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('status', 'Product created successfully!');
        }

        return redirect()->route('products.index')->with('error', 'Failed to create product. Please try again.');
    }

    // Function to update a product
    public function update(Request $request, $id)
    {
        // Validasi input data yang diterima (name, price, quantity, category_id, genre_id, image)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'genre_id' => 'nullable|exists:genres,id',
            'image_url' => 'nullable|url',
        ]);

        // Ambil data dari request
        $name = $request->input('name');
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $categoryId = $request->input('category_id');
        $genreId = $request->input('genre_id', null);  // Genre ID opsional
        $imageUrl = $request->input('image_url', null);

        $data = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'category_id' => $categoryId,
            'genre_id' => $genreId,
            'image_url' => $imageUrl,
        ];

        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->put("{$this->springBootApiUrl}/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('status', 'Product updated successfully!');
        }

        return redirect()->route('products.index')->with('error', 'Failed to update product. Please try again.');
    }

    
    

    // Function to get product by ID
    public function getProduct($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->get("{$this->springBootApiUrl}/{$id}");
    
        if ($response->successful()) {
            $product = $response->json()['data'] ?? null; // Cek apakah key 'data' tersedia
            return response()->json([
                'status' => 'success',
                'data' => $product,
            ]);
        }
    
        return response()->json([
            'status' => 'error',
            'message' => $response->json()['message'] ?? 'An unexpected error occurred',
        ], $response->status());
    }
    

    // Function to list products
    public function listProducts(Request $request)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret', 
        ])->get($this->springBootApiUrl, [
            'page' => $request->query('page', 0),
            'size' => $request->query('size', 10),
        ]);
    
        if ($response->successful()) {
            // Pastikan 'data' tersedia di respons
            $products = $response->json()['data'] ?? [];
            return view('products.index', compact('products'));
        }
    
        // Jika gagal, kembalikan view dengan informasi tambahan
        $errorMessage = $response->json()['message'] ?? 'An unexpected error occurred';
        $statusCode = $response->status();
        return view('products.index', [
            'products' => [], // Kirimkan produk kosong
            'error' => $errorMessage,
            'status' => $statusCode, // Tambahkan status untuk debugging
        ]);
    }
    


// Function to list products
//    public function listProducts(Request $request)
//    {
//        $response = Http::withHeaders([
//            'X-Api-Key' => 'secret',
//        ])->get($this->springBootApiUrl, [
//            'page' => $request->query('page', 0),
//            'size' => $request->query('size', 10),
//        ]);
//
//        if ($response->successful()) {
//            return response()->json([
//                'status' => 'success',
//                'data' => $response->json()['data']
//            ]);
//        }
//
//        return response()->json([
//            'status' => 'error',
//            'message' => $response->json()['message']
//        ], $response->status());
//    }

    // Function to delete a product
    public function delete($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->delete("{$this->springBootApiUrl}/{$id}");

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $id
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $response->json()['message']
        ], $response->status());
    }
}
