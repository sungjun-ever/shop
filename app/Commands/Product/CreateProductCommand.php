<?php

namespace App\Commands\Product;

use App\Enum\ProductStatus;

class CreateProductCommand
{
    public string $name;
    public string $slug;
    public string $shortDescription;
    public string $fullDescription;
    public int $sellerId;
    public int $brandId;
    public ProductStatus $status;

    /**
     * @param string $name
     * @param string $slug
     * @param string $shortDescription
     * @param string $fullDescription
     * @param int $sellerId
     * @param int $brandId
     * @param ProductStatus $status
     */
    public function __construct(string $name, string $slug, string $shortDescription, string $fullDescription, int $sellerId, int $brandId, ProductStatus $status)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->shortDescription = $shortDescription;
        $this->fullDescription = $fullDescription;
        $this->sellerId = $sellerId;
        $this->brandId = $brandId;
        $this->status = $status;
    }


}