<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductService
{
    protected $apiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products';

    /**
     * Fetch product details from the external API.
     *
     * @param int $productId
     * @return array
     */
    public function getProductById(int $productId)
    {
        $response = Http::get("{$this->apiUrl}/{$productId}");

        // If the API request fails, throw an exception
        if ($response->failed()) {
            throw new \Exception('Failed to fetch product details');
        }

        return $response->json();
    }

    /**
     * Fetch all products from the external API.
     *
     * @return array
     */
    public function getAllProducts()
    {
        $response = Http::get($this->apiUrl);

        // If the API request fails, throw an exception
        if ($response->failed()) {
            throw new \Exception('Failed to fetch products');
        }

        return $response->json();
    }
}
