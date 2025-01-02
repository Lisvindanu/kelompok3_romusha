<?php

namespace App\Models\Inventory;

class UseInventoryItemRequest
{
    public function __construct(
        public int $userId,
        public int $itemId,
        public int $quantity
    ) {}
}
