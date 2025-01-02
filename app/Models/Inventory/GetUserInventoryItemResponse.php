<?php

namespace App\Models\Inventory;

class GetUserInventoryItemResponse
{
    public function __construct(
        public int $code,
        public string $status,
        public array $data
    ) {}
}
