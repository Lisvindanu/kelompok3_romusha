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
        // Get file from the request
        $file = $request->file('file');

        // Prepare the request data
        $body = $request->input('body'); // Assuming body is a JSON string, otherwise handle it accordingly

        // Prepare the multipart form data
        $multipartData = [
            'body' => $body,
            'file' => $file
        ];

        // Send the request to Spring Boot API
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret', // Add your API key here
        ])->post($this->springBootApiUrl, $multipartData);

        // Check if the response was successful
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json()['data']
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $response->json()['message']
        ], $response->status());
    }

    // Function to update a product
    public function update(Request $request, $id)
    {
        $file = $request->file('file');
        $body = $request->input('body');

        $multipartData = [
            'body' => $body,
            'file' => $file,
        ];

        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->put("{$this->springBootApiUrl}/{$id}", $multipartData);

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json()['data']
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $response->json()['message']
        ], $response->status());
    }

    // Function to get product by ID
    public function getProduct($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->get("{$this->springBootApiUrl}/{$id}");

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json()['data']
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $response->json()['message']
        ], $response->status());
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

// Function to list products
    public function listProducts(Request $request)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret', // Pastikan API key sudah sesuai
        ])->get($this->springBootApiUrl, [
            'page' => $request->query('page', 0),
            'size' => $request->query('size', 10),
        ]);

        if ($response->successful()) {
            // Kirim data produk ke view
            $products = $response->json()['data'];
            return view('products.index', compact('products'));
        }

        // Jika gagal, kembalikan view dengan pesan error
        return view('products.index', ['error' => $response->json()['message']]);
    }

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
