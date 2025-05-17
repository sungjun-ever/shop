<?php

namespace App\Commands\Product\Data;

readonly class ProductDetailDimensionData
{

    public function __construct(
        public ?int $width,
        public ?int $height,
        public ?int $depth,
    )
    {
    }
}