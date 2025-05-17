<?php

namespace App\DTO\ProductPrice;

readonly class CreateProductPriceDTO
{

    public function __construct(
        public int $productId,
        public float $basePrice,
        public float $salePrice,
        public float $costPrice,
        public string $currency,
        public float $taxRate,
    )
    {
    }
}