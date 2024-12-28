<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    protected $springBootApiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products';

    public function create(Request $request)
    {
        try {
            // Decode the JSON body from FormData
            $bodyData = json_decode($request->input('body'), true);

            if (!$bodyData) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Invalid JSON data'
                ], 400);
            }

            // Merge the decoded body data with the request
            $request->merge($bodyData);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'specifications' => 'nullable|string',
                'price' => 'required|numeric|min:1',
                'quantity' => 'required|integer|min:0',
                'categoryId' => 'required|integer', // Changed from category_id
                'genreIds' => 'nullable|array',
                'genreIds.*' => 'integer', // Changed from genre_ids
                'file' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);

            // Send directly to Spring Boot API without transforming the field names
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])
                ->attach(
                    'file',
                    $request->hasFile('file') ? fopen($request->file('file')->path(), 'r') : null,
                    $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : null
                )
                ->post($this->springBootApiUrl, [
                    'body' => $request->input('body') // Send the original JSON string
                ]);

            if ($response->successful()) {
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'data' => $response->json()['data']
                ]);
            }

            return response()->json([
                'code' => $response->status(),
                'status' => 'error',
                'message' => $response->json()['message'] ?? 'Failed to create product'
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

//    public function update(Request $request, $id)
//    {
//        try {
//            // Decode JSON dari field 'body' yang diterima dari FormData
//            $bodyData = json_decode($request->input('body'), true);
//
//            // Cek apakah JSON valid
//            if (!$bodyData) {
//                return response()->json([
//                    'code' => 400,
//                    'status' => 'error',
//                    'message' => 'Invalid JSON data in "body".'
//                ], 400);
//            }
//
//            // Gabungkan data body ke dalam request untuk validasi
//            $request->merge($bodyData);
//
//            // Validasi data
//            $validated = $request->validate([
//                'name' => 'required|string|max:255',
//                'description' => 'nullable|string',
//                'specifications' => 'nullable|string',
//                'price' => 'required|numeric|min:1',
//                'quantity' => 'required|integer|min:0',
//                'categoryId' => 'required|integer',
//                'genreIds' => 'nullable|array',
//                'genreIds.*' => 'integer',
//                'file' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
//            ]);
//
//            // Kirim data ke Spring Boot API
//            $response = Http::withHeaders([
//                'X-Api-Key' => 'secret',
//                'Accept' => 'application/json'
//            ])->attach(
//                'file',
//                $request->hasFile('file') ? fopen($request->file('file')->path(), 'r') : null,
//                $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : null
//            )->put("{$this->springBootApiUrl}/{$id}", [
//                'body' => $request->input('body') // Kirim JSON asli
//            ]);
//
//            if ($response->successful()) {
//                return response()->json([
//                    'code' => 200,
//                    'status' => 'success',
//                    'data' => $response->json()['data'],
//                    'message' => 'Product updated successfully.'
//                ]);
//            }
//
//            return response()->json([
//                'code' => $response->status(),
//                'status' => 'error',
//                'message' => $response->json()['message'] ?? 'Failed to update product'
//            ], $response->status());
//        } catch (\Exception $e) {
//            return response()->json([
//                'code' => 500,
//                'status' => 'error',
//                'message' => 'Internal server error: ' . $e->getMessage()
//            ], 500);
//        }
//    }

    public function update(Request $request, $id)
    {
        try {
            // Ambil data dari body
            $bodyContent = $request->get('body');

            if (!$bodyContent) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Body parameter is required'
                ], 400);
            }

            // Decode JSON content
            $bodyData = json_decode($bodyContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Invalid JSON format: ' . json_last_error_msg()
                ], 400);
            }

            // Validasi data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'specifications' => 'nullable|string',
                'price' => 'required|numeric|min:1',
                'quantity' => 'required|integer|min:0',
                'categoryId' => 'required|integer',
                'genreIds' => 'nullable|array',
                'genreIds.*' => 'integer',
                'file' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);

            // Kirim data ke Spring Boot API
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->attach(
                'file',
                $request->hasFile('file') ? fopen($request->file('file')->path(), 'r') : null,
                $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : null
            )->put("{$this->springBootApiUrl}/{$id}", [
                'body' => json_encode($bodyData) // Kirim JSON asli
            ]);

            if ($response->successful()) {
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'data' => $response->json()['data'],
                    'message' => 'Product updated successfully.'
                ]);
            }

            return response()->json([
                'code' => $response->status(),
                'status' => 'error',
                'message' => $response->json()['message'] ?? 'Failed to update product'
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->delete("{$this->springBootApiUrl}/{$id}");

            if ($response->successful()) {
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'data' => $id,
                    'message' => 'Product deleted successfully.'
                ]);
            }

            return response()->json([
                'code' => $response->status(),
                'status' => 'error',
                'message' => $response->json()['message'] ?? 'Failed to delete product'
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listProducts(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->get($this->springBootApiUrl, [
                'page' => $request->query('page', 0),
                'size' => $request->query('size', 15)
            ]);

            if ($response->successful()) {
                $products = $response->json()['data'];

                // Check if request wants JSON response
                if ($request->expectsJson()) {
                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'data' => $products,
                        'message' => 'Products retrieved successfully.'
                    ]);
                }

                // Return view for web request
                return view('products.index', compact('products'));
            }

            $errorMessage = $response->json()['message'] ?? 'Failed to retrieve products';

            if ($request->expectsJson()) {
                return response()->json([
                    'code' => $response->status(),
                    'status' => 'error',
                    'message' => $errorMessage
                ], $response->status());
            }

            return view('products.index', [
                'products' => [],
                'error' => $errorMessage
            ]);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Internal server error: ' . $e->getMessage()
                ], 500);
            }

            return view('products.index', [
                'products' => [],
                'error' => 'Internal server error'
            ]);
        }
    }

    public function getProduct($id)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->get("{$this->springBootApiUrl}/{$id}");

            if ($response->successful()) {
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'data' => $response->json()['data'],
                    'message' => 'Product retrieved successfully.'
                ]);
            }

            return response()->json([
                'code' => $response->status(),
                'status' => 'error',
                'message' => $response->json()['message'] ?? 'Failed to retrieve product'
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
