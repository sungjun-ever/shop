<?php

namespace App\Commands\Product\Data;

readonly class ProductImageData
{

    public function __construct(
        public string $url,
        public ?string $altText,
        public ?bool $isPrimary = false,
        public ?int $displayOrder = 0,
        public ?int $optionId,
    )
    {
    }
}