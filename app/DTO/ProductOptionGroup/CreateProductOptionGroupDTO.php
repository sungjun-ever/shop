<?php

namespace App\DTO\ProductOptionGroup;

readonly class CreateProductOptionGroupDTO
{

    public function __construct(
        public int $productId,
        public string $name,
        public int $displayOrder,
    )
    {
    }
}