<?php
namespace App\Http\Controllers;

use App\Services\PurchaseService;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Inventory;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    protected $productService;
    protected $purchaseService;

    public function __construct(ProductService $productService, PurchaseService $purchaseService)
    {
        $this->productService = $productService;
        $this->purchaseService = $purchaseService;
    }

    public function create(PurchaseRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $product = $this->productService->getProduct($validatedData['product_id']);

            if (!$this->productService->validateProduct($validatedData['product_id'], $validatedData['quantity'])) {
                throw new \Exception('Insufficient product stock');
            }

            $purchase = $this->purchaseService->createPurchase($validatedData);

            DB::commit();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $purchase
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function history($userId): JsonResponse
    {


        $purchases = Purchase::with('user')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($purchase) {
                $product = $this->productService->getProduct($purchase->product_id);
                return [
                    'purchase_id' => $purchase->id,
                    'product_name' => $product['name'] ?? 'Unknown Product',
                    'quantity' => $purchase->quantity,
                    'total_price' => $purchase->total_price,
                    'created_at' => $purchase->created_at
                ];
            });

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $purchases
        ]);
    }
}
