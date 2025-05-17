<?php

namespace App\Commands\Product\Data;

readonly class ProductDetailAdditionalInfoData
{

    public function __construct(
        public ?bool $assemblyRequired,
        public ?string $assemblyTime,
    )
    {
    }
}