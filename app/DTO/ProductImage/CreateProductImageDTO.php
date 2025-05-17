<?php

namespace App\DTO\ProductImage;

class CreateProductImageDTO
{

    public function __construct(
        public int $productId,
        public string $url,
        public string $altText,
        public bool $isPrimary,
        public int $displayOrder,
        public int $optionId,
    )
    {
    }
}