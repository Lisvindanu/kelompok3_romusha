<?php

namespace App\Models\Inventory;

class UseInventoryItemResponse
{
    public function __construct(
        public int $code,
        public string $status,
        public UseInventoryItemResponseData $data
    ) {}
}
