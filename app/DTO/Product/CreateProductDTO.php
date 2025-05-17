<?php

namespace App\DTO\Product;

use App\Enum\ProductStatus;

readonly class CreateProductDTO
{
    public function __construct(
        public string $name,
        public string $slug,
        public ?string $shortDescription,
        public ?string $fullDescription,
        public ?int $sellerId,
        public ?int $brandId,
        public ProductStatus $status,
    )
    {
    }
}