<?php

namespace App\QueryHandlers\Product;

use App\Models\Product;
use App\Queries\Product\GetProductsQuery;
use App\QueryHandlers\QueryHandlerInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProductsQueryHandler implements QueryHandlerInterface
{
    public function handler(GetProductsQuery $query): LengthAwarePaginator
    {
        return Product::query()
            ->when($query->sellerId, fn($q) => $this->filterBySeller($q, $query->sellerId))
            ->when($query->brandId, fn($q) => $this->filterByBrand($q, $query->brandId))
            ->when($query->categoryId, fn($q) => $this->filterByCategory($q, $query->categoryId))
            ->when(!is_null($query->inStock), fn($q) => $this->filterByStock($q, $query->inStock))
            ->when($this->hasPriceFilter($query), fn($q) => $this->filterByPrice($q, $query))
            ->when($query->search, fn($q) => $this->filterBySearch($q, $query->search))
            ->when($query->status, fn($q) => $q->where('status', $query->status))
            ->when($query->sort, fn($q) => $this->applySorting($q, $query->sort))
            ->paginate(perPage: $query->perPage, page: $query->page);
    }

    private function filterBySeller($query, int $sellerId)
    {
        return $query->with(['seller' => function ($q) use ($sellerId) {
            $q->select('id', 'name')->where('id', $sellerId);
        }]);
    }

    private function filterByBrand($query, int $brandId)
    {
        return $query->with(['brand' => function ($q) use ($brandId) {
            $q->select('id', 'name')->where('id', $brandId);
        }]);
    }

    private function filterByCategory($query, array $categoryId)
    {
        return $query->with(['productCategory' => function ($q) use ($categoryId) {
            $q->select('id', 'product_id', 'category_id')
                ->whereIn('category_id', $categoryId);
        }]);
    }

    private function filterByStock($query, bool $inStock)
    {
        return $query->with(['productOption' => function ($q) use ($inStock) {
            $q->select('id', 'stock')
                ->where('stock', $inStock ? '>' : '=', 0);
        }]);
    }

    private function hasPriceFilter(GetProductsQuery $query): bool
    {
        return !is_null($query->minPrice) || !is_null($query->maxPrice);
    }

    private function filterByPrice($query, GetProductsQuery $queryObj)
    {
        return $query->with(['productPrice' => function ($q) use ($queryObj) {
            $q->select('id', 'base_price');

            match (true) {
                $queryObj->minPrice >= 0 && $queryObj->maxPrice >= 0 =>
                $q->whereBetween('base_price', [$queryObj->minPrice, $queryObj->maxPrice]),
                $queryObj->minPrice >= 0 =>
                $q->where('base_price', '>=', $queryObj->minPrice),
                default =>
                $q->where('base_price', '<=', $queryObj->maxPrice)
            };
        }]);
    }

    private function filterBySearch($query, string $search)
    {
        return $query->whereAny([
            'name',
            'short_description',
            'full_description'
        ], 'like', "{$search}%");
    }

    private function applySorting($query, ?string $sort): void
    {
        if (empty($sort)) return;

        collect(explode(',', $sort))
            ->map(fn($item) => explode(':', $item))
            ->each(fn($parts) => $query->orderBy($parts[0], $parts[1] ?? 'asc'));
    }
}