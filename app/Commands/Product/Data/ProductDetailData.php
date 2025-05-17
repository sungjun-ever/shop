<?php

namespace App\Commands\Product\Data;

readonly class ProductDetailData
{

    public function __construct(
        public ?float  $weight,
        public ?ProductDetailDimensionData $dimensions,
        public ?string $materials,
        public ?string $countryOfOrigin,
        public ?string $warrantyInfo,
        public ?string $careInstructions,
        public ?ProductDetailAdditionalInfoData $additionalInfo,
    )
    {
    }
}