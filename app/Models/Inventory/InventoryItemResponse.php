<?php

namespace App\Models\Inventory;

class InventoryItemResponse
{
    public function __construct(
        public int $itemId,
        public string $name,
        public int $quantity,
        public string $lastUpdated,
        public ?string $imageUrl
    ) {}
}
