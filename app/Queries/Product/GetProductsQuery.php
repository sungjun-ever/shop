<?php

namespace App\Queries\Product;

use App\Enum\ProductStatus;
use App\Queries\QueryInterface;

class GetProductsQuery implements QueryInterface
{
    public int $page;
    public int $perPage;
    public string $sort;
    public ?ProductStatus $status;
    public ?int $minPrice;
    public ?int $maxPrice;
    public ?array $categoryId;
    public ?int $sellerId;
    public ?int $brandId;
    public ?bool $inStock;
    public ?string $search;

    /**
     * @param int|null $page
     * @param int|null $perPage
     * @param string|null $sort
     * @param ProductStatus|null $status
     * @param int|null $minPrice
     * @param int|null $maxPrice
     * @param array|null $categoryId
     * @param int|null $sellerId
     * @param int|null $brandId
     * @param bool|null $inStock
     * @param string|null $search
     */
    public function __construct(
        ?int           $page,
        ?int           $perPage,
        ?string        $sort,
        ?ProductStatus $status,
        ?int           $minPrice,
        ?int           $maxPrice,
        ?array         $categoryId,
        ?int           $sellerId,
        ?int           $brandId,
        ?bool          $inStock,
        ?string        $search
    )
    {
        $this->page = $page ?: 1;
        $this->perPage = $perPage ?: 10;
        $this->sort = $sort ?: "created_at:desc";
        $this->status = $status;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
        $this->categoryId = $categoryId;
        $this->sellerId = $sellerId;
        $this->brandId = $brandId;
        $this->inStock = $inStock;
        $this->search = $search;
    }


}