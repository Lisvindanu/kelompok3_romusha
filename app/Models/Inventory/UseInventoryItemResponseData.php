<?php

namespace App\Models\Inventory;

class UseInventoryItemResponseData
{
    public function __construct(
        public int $itemId,
        public string $name,
        public int $remainingQuantity,
        public string $lastUpdated,
        public ?string $imageUrl
    ) {}
}
