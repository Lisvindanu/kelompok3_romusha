<?php

namespace App\Http\Controllers;

use App\Models\Inventory\GetUserInventoryItemResponse;
use App\Models\Inventory\UseInventoryItemRequest;
use App\Models\WebResponse;
use App\Services\InventoryServices;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;  

class InventoryController extends Controller
{
    protected InventoryServices $inventoryServices;

    public function __construct(InventoryServices $inventoryServices)
    {
        $this->inventoryServices = $inventoryServices;
    }

    // Get user inventory
    public function getUserInventory(Request $request): JsonResponse
    {
        $userId = $request->query('userId');
        $response = $this->inventoryServices->getUserInventory($userId);

        return response()->json([
            'code' => 200,
            'status' => $response->status,
            'data' => $response
        ]);
    }

    // Use an inventory item
    public function useInventoryItem(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'userId' => 'required|integer',
            'itemId' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        $useRequest = new UseInventoryItemRequest(
            $validatedData['userId'],
            $validatedData['itemId'],
            $validatedData['quantity']
        );

        $response = $this->inventoryServices->useInventoryItem($useRequest);

        return response()->json([
            'code' => $response->code,
            'status' => $response->status,
            'data' => $response
        ]);
    }
}
