<?php

namespace App\DTO\ProductOption;

readonly class CreateProductOptionDTO
{

    public function __construct(
        public int $optionGroupId,
        public string $name,
        public float $additionalPrice,
        public string $sku,
        public int $stock,
        public int $displayOrder,
    )
    {
    }
}