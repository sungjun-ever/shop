<?php

namespace App\Commands\Product\Data;

readonly class ProductCategoryData
{
    public function __construct(
        public ?int  $categoryId,
        public ?bool $isPrimary = false,
    )
    {
    }
}