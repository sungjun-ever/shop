<?php

namespace App\DTO\ProductOption;

readonly class CreateProductOptionDTO
{

    public function __construct(
        public ?int $optionGroupId,
        public string $name,
        public ?float $additionalPrice = 0,
        public ?string $sku,
        public ?int $stock = 0,
        public ?int $displayOrder = 0,
    )
    {
    }
}