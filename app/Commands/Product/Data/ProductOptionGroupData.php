<?php

namespace App\Commands\Product\Data;

readonly class ProductOptionGroupData
{

    public function __construct(
        public string $name,
        public ?int $displayOrder = 0,
        public ProductOptionData|array $options,
    )
    {
    }
}