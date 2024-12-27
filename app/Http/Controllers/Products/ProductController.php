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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        // Prepare the JSON body
        $body = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'specifications' => $request->input('specifications'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'categoryId' => $request->input('category_id'),
            'genreIds' => $request->input('genre_ids', [])
        ];

        // Create multipart form data
        $formData = [
            'body' => json_encode($body),
        ];

        // Add file if present
        if ($request->hasFile('file')) {
            $formData['file'] = fopen($request->file('file')->path(), 'r');
        }

        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->attach(
            'file',
            $request->hasFile('file') ? fopen($request->file('file')->path(), 'r') : null,
            $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : null
        )->post($this->springBootApiUrl, $formData);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('status', 'Product created successfully!');
        }

        return redirect()->route('products.index')
            ->with('error', 'Failed to create product: ' . ($response->json()['message'] ?? 'Unknown error'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        // Prepare the JSON body
        $body = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'specifications' => $request->input('specifications'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'categoryId' => $request->input('category_id'),
            'genreIds' => $request->input('genre_ids', []),
            'imageUrl' => $request->input('image_url')
        ];

        // Create multipart form data
        $formData = [
            'body' => json_encode($body),
        ];

        // Add file if present
        if ($request->hasFile('file')) {
            $formData['file'] = fopen($request->file('file')->path(), 'r');
        }

        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->attach(
            'file',
            $request->hasFile('file') ? fopen($request->file('file')->path(), 'r') : null,
            $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : null
        )->put("{$this->springBootApiUrl}/{$id}", $formData);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('status', 'Product updated successfully!');
        }

        return redirect()->route('products.index')
            ->with('error', 'Failed to update product: ' . ($response->json()['message'] ?? 'Unknown error'));
    }

    public function getProduct($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->get("{$this->springBootApiUrl}/{$id}");

        if ($response->successful()) {
            $product = $response->json()['data'];
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $product,
                'message' => 'Product details retrieved successfully.'
            ]);
        }

        return response()->json([
            'code' => $response->status(),
            'status' => 'error',
            'data' => null,
            'message' => $response->json()['message'] ?? 'Failed to retrieve product details'
        ], $response->status());
    }

    public function listProducts(Request $request)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->get($this->springBootApiUrl, [
            'page' => $request->query('page', 0),
            'size' => $request->query('size', 10),
        ]);

        if ($response->successful()) {
            $products = $response->json()['data'];

            if ($request->expectsJson()) {
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'data' => $products,
                    'message' => 'Product list retrieved successfully.'
                ]);
            }
            return view('products.index', compact('products'));
        }

        $errorMessage = $response->json()['message'] ?? 'Failed to retrieve products';

        if ($request->expectsJson()) {
            return response()->json([
                'code' => $response->status(),
                'status' => 'error',
                'data' => null,
                'message' => $errorMessage
            ], $response->status());
        }

        return view('products.index', [
            'products' => [],
            'error' => $errorMessage
        ]);
    }

    public function delete($id)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => 'secret',
        ])->delete("{$this->springBootApiUrl}/{$id}");

        if ($response->successful()) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $id,
                'message' => 'Product successfully deleted.'
            ]);
        }

        return response()->json([
            'code' => $response->status(),
            'status' => 'error',
            'data' => null,
            'message' => $response->json()['message'] ?? 'Failed to delete product'
        ], $response->status());
    }
}
