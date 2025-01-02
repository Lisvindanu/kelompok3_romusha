<?php

namespace App\Services;

use App\Models\Inventory\GetUserInventoryItemResponse;
use App\Models\Inventory\UseInventoryItemRequest;
use App\Models\Inventory\InventoryItemResponse;
use Illuminate\Support\Facades\Http; // Laravel HTTP Client
use Carbon\Carbon;

class InventoryServices 
{
    // protected $productApiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products';
    protected $springBootApiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products';

    // Get user inventory
    public function getUserInventory(int $userId): GetUserInventoryItemResponse
    {
        // Fetch inventory items for the user (this could be from a local DB or elsewhere)
        $inventoryItems = $this->getInventoryItemsForUser($userId);

        // Fetch product details from external API for each item
        $inventoryItemsResponse = $inventoryItems->map(function ($item) {
            // Fetch product info from external API
            $product = $this->getProductInfo($item->product_id);

            return new InventoryItemResponse(
                $product['id'] ?? -1,
                $product['name'],
                $item->quantity,
                Carbon::parse($item->last_updated)->toIso8601String(), // Format date in ISO 8601
                $product['image_url'] // Assuming the external API provides an 'image_url'
            );
        });

        // Return response with inventory data
        return new GetUserInventoryItemResponse(
            200,
            'success',
            $inventoryItemsResponse->toArray()
        );
    }

    // Use inventory item
    public function useInventoryItem(UseInventoryItemRequest $request): GetUserInventoryItemResponse
    {
        // Find the inventory item for the user
        $inventoryItem = $this->getInventoryItemForUserAndProduct($request->userId, $request->itemId);

        if (!$inventoryItem) {
            throw new \InvalidArgumentException("Item not found in user's inventory");
        }

        if ($inventoryItem->quantity < $request->quantity) {
            throw new \InvalidArgumentException("Insufficient item quantity");
        }

        // Update inventory
        $remainingQuantity = $inventoryItem->quantity - $request->quantity;
        $inventoryItem->quantity = $remainingQuantity;
        $inventoryItem->last_updated = Carbon::now();
        $inventoryItem->save();

        // Fetch product info again from external API
        $product = $this->getProductInfo($inventoryItem->product_id);

        // Return updated inventory item in response
        $responseData = new InventoryItemResponse(
            $product['id'] ?? -1,
            $product['name'],
            $remainingQuantity,
            $inventoryItem->last_updated->toIso8601String(),
            $product['image_url']
        );

        return new GetUserInventoryItemResponse(
            200,
            'success',
            [$responseData]
        );
    }

    // Update inventory after purchase
    public function updateInventoryAfterPurchase(int $userId, int $itemId, int $quantity): bool
    {
        // Find the inventory for the user and item
        $inventory = $this->getInventoryItemForUserAndProduct($userId, $itemId);

        if ($inventory && $inventory->quantity >= $quantity) {
            $inventory->quantity -= $quantity;
            $inventory->save();
            return true;
        }

        return false;
    }

    // Helper method to fetch product data from external API
    private function getProductInfo(int $productId)
    {
        // Example of an API request to fetch product details
        // $response = Http::get("{$this->productApiUrl}/{$productId}");
        $response = Http::get("{$this->springBootApiUrl}/{$productId}");

        // Check if the request was successful
        if ($response->successful()) {
            return $response->json(); // Returns the product data as an array
        }

        // If API request fails, return default values or handle error
        return [
            'id' => -1,
            'name' => 'Unknown Product',
            'image_url' => null
        ];
    }

    // Simulate fetching inventory items for a user (this could be a DB call or another service)
    private function getInventoryItemsForUser(int $userId)
    {
        // Example inventory data (replace with actual data source, like a DB)
        return collect([
            (object)[
                'product_id' => 1,
                'quantity' => 5,
                'last_updated' => Carbon::now()->subDays(1)
            ],
            (object)[
                'product_id' => 2,
                'quantity' => 3,
                'last_updated' => Carbon::now()->subDays(2)
            ]
        ]);
    }

    // Simulate fetching a specific inventory item for a user (this could be a DB call or another service)
    private function getInventoryItemForUserAndProduct(int $userId, int $productId)
    {
        // Example inventory item (replace with actual data source)
        return (object)[
            'product_id' => $productId,
            'quantity' => 5,
            'last_updated' => Carbon::now()->subDays(1),
            'save' => function () {
                // Simulate saving the item (implement actual save logic)
            }
        ];
    }
}
