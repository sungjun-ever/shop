<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $stock = 0;

        return [
            'item' => $this->collection->map(function ($item) use (&$stock) {
                $item->productOptionGroups->pluck('productOptions')->map(function ($item) use (&$stock) {
                    $stock += $item->sum('stock');
                });

                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'slug' => $item->slug,
                    'short_description' => $item->short_description,
                    'base_price' => $item->productPrice->base_price,
                    'sale_price' => $item->productprice->sale_price,
                    'currency' => $item->productPrice->currency,
                    'primary_images' => [
                        'url' => $item->productImages->first()->url,
                        'alt_text' => $item->productImages->first()->alt_text,
                    ],
                    'brand' => [
                        'id' => $item->brand->id,
                        'name' => $item->brand->name,
                    ],
                    'seller' => [
                        'id' => $item->seller->id,
                        'name' => $item->seller->name,
                    ],
                    'rating' => number_format($item->productReviews->first()->rating, 1, '.'),
                    'review_count' => $item->productReviews->first()->review_count,
                    'in_stock' => $stock > 0,
                    'status' => $item->status,
                    'created_at' => $item->created_at
                ];
            }),
            'pagination' => [
                "total_items" => $this->resource->total(),
                "total_pages" => $this->resource->lastPage(),
                "current_page" => $this->resource->currentPage(),
                "per_page" => $this->resource->perPage(),
            ],
        ];
    }
}
