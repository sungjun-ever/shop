<?php

namespace App\QueryHandlers\Product;

use App\Models\Product;
use App\Queries\Product\GetProductsQuery;
use App\QueryHandlers\QueryHandlerInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProductsQueryHandler implements QueryHandlerInterface
{
    public function handler(GetProductsQuery $query): LengthAwarePaginator
    {
        return Product::query()
            ->with([
                'brand',
                'seller',
                'productImages' => function ($q) use ($query) {
                    $q->select('id', 'product_id', 'url', 'alt_text')
                        ->where('is_primary', true);
                },
                'productReviews' => function ($q) {
                    $q->selectRaw('MIN(id) as id, product_id, AVG(rating) as rating, COUNT(id) as review_count')
                        ->groupBy('product_id');
                }
            ])
            ->when($query->sellerId, fn($q) => $this->filterBySeller($q, $query->sellerId))
            ->when($query->brandId, fn($q) => $this->filterByBrand($q, $query->brandId))
            ->when($query->categoryId, fn($q) => $this->filterByCategory($q, $query->categoryId))
            ->tap(fn($q) => $this->filterByStock($q, $query->inStock))
            ->when($this->hasPriceFilter($query), fn($q) => $this->filterByPrice($q, $query))
            ->when($query->search, fn($q) => $this->filterBySearch($q, $query->search))
            ->when($query->status, fn($q) => $q->where('status', $query->status))
            ->when($query->sort, fn($q) => $this->applySorting($q, $query->sort))
            ->paginate(perPage: $query->perPage, page: $query->page);
    }

    private function filterBySeller($query, int $sellerId): Builder|\Illuminate\Database\Eloquent\Builder
    {
        return $query->whereHas('seller', function ($q) use ($sellerId) {
            $q->where('id', $sellerId);
        });
    }

    private function filterByBrand($query, int $brandId): Builder|\Illuminate\Database\Eloquent\Builder
    {
        return $query->whereHas('brand', function ($q) use ($brandId) {
           $q->where('id', $brandId);
        });
    }

    private function filterByCategory($query, array $categoryId): Builder|\Illuminate\Database\Eloquent\Builder
    {
        return $query->with(['productCategories' => function ($q) use ($categoryId) {
            $q->select('id', 'product_id', 'category_id')
                ->whereIn('category_id', $categoryId);
        }]);
    }

    private function filterByStock($query, ?bool $inStock): Builder|\Illuminate\Database\Eloquent\Builder
    {
        return $query->with([
            'productOptionGroups' => function ($q) use ($inStock) {
                $q->select('id', 'product_id')
                    ->with([
                        'productOptions' => function ($subQ) use ($inStock) {
                            $subQ->select('id', 'option_group_id', 'stock');
                            if (!is_null($inStock)) {
                                $subQ->where('stock', $inStock ? '>' : '=', 0);
                            }
                        }
                    ]);
            }
        ]);
    }

    private function hasPriceFilter(GetProductsQuery $query): bool
    {
        return !is_null($query->minPrice) || !is_null($query->maxPrice);
    }

    private function filterByPrice($query, GetProductsQuery $queryObj): Builder|\Illuminate\Database\Eloquent\Builder
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

    private function filterBySearch($query, string $search): Builder|\Illuminate\Database\Eloquent\Builder
    {
        return $query->whereAny([
            'name',
            'short_description',
            'full_description'
        ], 'like', "{$search}%");
    }

    private function applySorting($query, ?string $sort): void
    {
        collect(explode(',', $sort))
            ->map(fn($item) => explode(':', $item))
            ->each(fn($parts) => $query->orderBy($parts[0], $parts[1] ?? 'asc'));
    }
}