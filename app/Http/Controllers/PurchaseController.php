<?php

namespace App\Http\Controllers;

use App\Models\WebResponse;
use App\Services\PurchaseService;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    protected PurchaseService $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    /**
     * Create a new purchase.
     *
     * @param PurchaseRequest $request
     * @return JsonResponse
     */
    public function create(PurchaseRequest $request): JsonResponse
    {
        // The $request has already been validated automatically using the PurchaseRequest rules
        $validatedData = $request->validated();
    
        // Call PurchaseService to handle the purchase creation logic
        try {
            $purchase = $this->purchaseService->createPurchase($validatedData);
    
            // Return the success response with purchase data
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $purchase
            ]);
        } catch (\Exception $e) {
            // In case of any error, return the error response
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}
