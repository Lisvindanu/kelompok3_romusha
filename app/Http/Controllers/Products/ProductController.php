<?php

namespace App\Http\Controllers\Products;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    // Method to create a product
    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|mimes:jpeg,png|max:2048'
        ]);

        // Handle file upload if present
        $imageUrl = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $imageUrl = $file->store('public/uploads/images');
        }

        // Create the product
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image_url' => $imageUrl
        ]);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $product
        ]);
    }

    // Method to update a product
    public function updateProduct($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|mimes:jpeg,png|max:2048'
        ]);

        // Handle file upload if present
        $imageUrl = $product->image_url;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Delete old image if it exists
            if ($imageUrl) {
                Storage::delete($imageUrl);
            }
            $imageUrl = $file->store('public/uploads/images');
        }

        // Update the product
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image_url' => $imageUrl
        ]);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $product
        ]);
    }

    // Method to delete a product
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image_url) {
            Storage::delete($product->image_url);
        }
        $product->delete();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $id
        ]);
    }

    // Method to list products
    public function listProducts(Request $request)
    {
        $request->validate([
            'page' => 'nullable|integer|min:0',
            'size' => 'nullable|integer|min:1'
        ]);

        $page = $request->get('page', 0);
        $size = $request->get('size', 10);

        $products = Product::with('category')
            ->skip($page * $size)
            ->take($size)
            ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $products
        ]);
    }

    // Method to get a product by ID
    public function getProductById($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $product
        ]);
    }
}
