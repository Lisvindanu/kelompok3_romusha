<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\User;
use App\Models\Product;
use App\Http\Requests\PurchaseRequest;
use App\Models\WebResponse;
use App\Services\ProductService;

class PurchaseService
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Create a new purchase.
     *
     * @param PurchaseRequest $request
     * @return Purchase
     */
    public function createPurchase(PurchaseRequest $request): Purchase
    {
        $product = $this->productService->getProductById($request->productId);
        $user = User::find($request->userId);

        if (!$product || !$user) {
            throw new \Exception('Product or User not found');
        }

        // Check product stock
        if ($product['quantity'] < $request->quantity) {
            throw new \Exception('Insufficient stock');
        }

        // Create purchase record
        $purchase = new Purchase();
        $purchase->user_id = $user->id;
        $purchase->product_id = $product['id'];
        $purchase->quantity = $request->quantity;
        $purchase->total_price = $product['price'] * $request->quantity;
        $purchase->save();

        // Reduce stock in the external API (you may also need to update the inventory)

        return $purchase;
    }
}
