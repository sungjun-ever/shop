<?php

namespace App\Commands\Product\Data;

readonly class ProductPriceData
{

    public function __construct(
        public float $basePrice,
        public ?float $salePrice,
        public ?float $costPrice,
        public ?string $currency = 'KRW',
        public ?float $taxRate,
    )
    {
    }
}