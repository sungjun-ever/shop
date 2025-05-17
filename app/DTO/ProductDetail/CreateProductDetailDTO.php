<?php

namespace App\DTO\ProductDetail;

readonly class CreateProductDetailDTO
{

    public function __construct(
        public int $productId,
        public float $weight,
        public string $dimensions,
        public string $materials,
        public string $countryOfOrigin,
        public string $warrantyInfo,
        public string $careInstructions,
        public string $additionalInfo,
    )
    {
    }
}