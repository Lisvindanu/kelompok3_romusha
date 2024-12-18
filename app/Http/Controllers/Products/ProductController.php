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
        // Validasi input
        $validated = $request->validate([
            'body' => 'required|json', // Body JSON wajib
            'file' => 'nullable|file|mimes:jpeg,png|max:2048', // File opsional dengan validasi tipe dan ukuran
        ]);
    
        // Ambil data body dan file
        $body = $request->input('body'); // JSON string
        $file = $request->file('file'); // File (opsional)
    
        // Siapkan multipart data
        $multipartData = [
            [
                'name' => 'body',
                'contents' => $body, // JSON string
            ],
        ];
    
        // Tambahkan file jika tersedia
        if ($file) {
            $multipartData[] = [
                'name' => 'file',
                'contents' => fopen($file->getPathname(), 'r'), // Konten file sebagai stream
                'filename' => $file->getClientOriginalName(), // Nama asli file
            ];
        }
    
        // Kirim ke API Spring Boot
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret', // API key
        ])->asMultipart()->post($this->springBootApiUrl, $multipartData);
    
        // Cek respons dari API
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json()['data'],
            ]);
        }
    
        return response()->json([
            'status' => 'error',
            'message' => $response->json()['message'] ?? 'Something went wrong',
        ], $response->status());
    }
    
    

    // Function to update a product
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'body' => 'required|json', // JSON wajib
            'file' => 'nullable|file|mimes:jpeg,png|max:2048', // File opsional
        ]);
    
        // Ambil data
        $body = $request->input('body');
        $file = $request->file('file');
    
        // Siapkan multipart data
        $multipartData = [
            [
                'name' => 'body',
                'contents' => $body,
            ],
        ];
    
        if ($file) {
            $multipartData[] = [
                'name' => 'file',
                'contents' => fopen($file->getPathname(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }
    
        // Kirim ke Spring Boot API
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->asMultipart()->put("{$this->springBootApiUrl}/{$id}", $multipartData);
    
        // Tangani respons
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json()['data'],
            ]);
        }
    
        return response()->json([
            'status' => 'error',
            'message' => $response->json()['message'] ?? 'Something went wrong',
        ], $response->status());
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
