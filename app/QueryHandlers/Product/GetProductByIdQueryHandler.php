<?php

namespace App\QueryHandlers\Product;

use App\Models\Product;
use App\Queries\Product\GetProductByIdQuery;
use App\QueryHandlers\QueryHandlerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetProductByIdQueryHandler implements QueryHandlerInterface
{
    public function handler(GetProductByIdQuery $query)
    {
        $product = Product::with([
            'brand',
            'seller',
            'productPrice',
            'productDetail',
            'productCategories.category.parentCategory',
            'productOptionGroups.productOptions',
            'productImages',
            'productTags.tag',
            'reviewStats',
            'reviewRatingDistribution',
        ])
            ->where('id', $query->id)
            ->first();

        if (!$product) {
            throw new ModelNotFoundException($query->id . ' not found');
        }

        $relatedProducts = Product::with([
            'productImages' => function ($q) {
                $q->select('id', 'product_id', 'url', 'alt_text')
                    ->where('is_primary', true);
            },
            'productPrice'
        ])
            ->whereHas('productCategories', function ($q) use ($product) {
                $q->whereIn('category_id', $product->productCategories->pluck('category_id'));
            })
            ->where('id', '!=', $product->id)
            ->limit(10)
            ->get();

        $product->relatedProducts = $relatedProducts;

        return $product;
    }
}