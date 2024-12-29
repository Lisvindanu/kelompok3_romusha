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
                'size' => $request->query('size', 100)
            ]);

            if ($response->successful()) {
                $products = $response->json()['data'];

                // Group products by category
                $groupedProducts = [];
                foreach ($products as $product) {
                    $categoryName = $product['categoryName'] ?? 'Uncategorized';
                    $groupedProducts[$categoryName][] = $product;
                }

                // Check if request wants JSON response
                if ($request->expectsJson()) {
                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'data' => $products,
                        'message' => 'Products retrieved successfully.'
                    ]);
                }

                // Return view with grouped products
                return view('dashboard.products.index', compact('groupedProducts'));
            }

            $errorMessage = $response->json()['message'] ?? 'Failed to retrieve products';

            if ($request->expectsJson()) {
                return response()->json([
                    'code' => $response->status(),
                    'status' => 'error',
                    'message' => $errorMessage
                ], $response->status());
            }

            return view('dashboard.products.index', [
                'groupedProducts' => [],
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

            return view('dashboard.products.index', [
                'groupedProducts' => [],
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

    public function getProductShow($id)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->get("{$this->springBootApiUrl}/{$id}");

            if ($response->successful()) {
                $product = $response->json()['data'];
                return view('dashboard.products.show-product', compact('product'));
            }

            return redirect()->route('dashboard.products.index')->with('error', 'Failed to retrieve product');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.products.index')->with('error', 'Internal server error: ' . $e->getMessage());
        }
    }

    public function listProductsByCategory(Request $request)
    {
        // Ambil semua produk dari API
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
            'Accept' => 'application/json'
        ])->get($this->springBootApiUrl);

        if ($response->successful()) {
            $products = $response->json()['data'];

            // Kelompokkan produk berdasarkan kategori
            $groupedProducts = [];
            foreach ($products as $product) {
                $groupedProducts[$product['categoryName']][] = $product;
            }

            // Pastikan $groupedProducts tidak null
            return view('dashboard.products.index', [
                'groupedProducts' => $groupedProducts ?? []
            ]);
        }

        // Handle error response
        return view('dashboard.products.index', [
            'groupedProducts' => [] // Kirim array kosong jika gagal
        ]);
    }

    public function createForm()
    {
        return view('dashboard.products.create-product');
    }

    public function updateForm($id)
    {
        return view('dashboard.products.update-product', ['id' => $id]);
    }
}
