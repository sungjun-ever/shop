<?php

namespace App\DTO\Product;

use App\Commands\Product\Data\ProductCategoryData;
use App\Commands\Product\Data\ProductDetailData;
use App\Commands\Product\Data\ProductImageData;
use App\Commands\Product\Data\ProductOptionGroupData;
use App\Commands\Product\Data\ProductPriceData;
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
        public ?ProductDetailData $details,
        public ?ProductPriceData $price,
        public ?ProductCategoryData $categories,
        public ?ProductOptionGroupData $optionGroups,
        public ?ProductImageData $images,
        public ?array $tags,
    )
    {
    }
}