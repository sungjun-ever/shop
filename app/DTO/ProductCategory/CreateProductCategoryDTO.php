<?php

namespace App\DTO\ProductCategory;

readonly class CreateProductCategoryDTO
{
    public function __construct(
        public int $productId,
        public int $categoryId,
        public bool $isPrimary,
    )
    {
    }
}