<?php

namespace App\Commands\Product\Data;

readonly class ProductOptionData
{

    public function __construct(
        public string $name,
        public ?float $additionalPrice = 0,
        public ?string $sku,
        public ?int $stock = 0,
        public ?int $displayOrder = 0,
    )
    {
    }
}