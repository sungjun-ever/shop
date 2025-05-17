<?php

namespace App\Commands\Product;

use App\Commands\CommandInterface;
use App\Commands\Product\Data\ProductCategoryData;
use App\Commands\Product\Data\ProductDetailData;
use App\Commands\Product\Data\ProductImageData;
use App\Commands\Product\Data\ProductOptionGroupData;
use App\Commands\Product\Data\ProductPriceData;
use App\Enum\ProductStatus;

class CreateProductCommand implements CommandInterface
{
    public function __construct(
        public string                       $name,
        public string                       $slug,
        public string                       $shortDescription,
        public string                       $fullDescription,
        public int                          $sellerId,
        public int                          $brandId,
        public ProductStatus                $status,
        public ?ProductDetailData           $details,
        public ?ProductPriceData            $price,
        public ProductCategoryData|array    $categories,
        public ProductOptionGroupData|array $optionGroups,
        public ProductImageData|array       $images,
        public array                        $tags,
    )
    {

    }


}