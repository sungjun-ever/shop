<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "short_description" => $this->short_description,
            "full_description" => $this->full_description,
            "seller" => [
                "id" => $this->seller->id,
                "name" => $this->seller->name,
                "description" => $this->seller->description,
                "logo_url" => $this->seller->logo_url,
                "rating" => $this->seller->rating,
                "contact_email" => $this->seller->contant_email,
                "contact_phone" => $this->seller->contact_phone,
            ],
            "brand" => [
                "id" => $this->brand->id,
                "name" => $this->brand->name,
                "description" => $this->brand->description,
                "logo_url" => $this->brand->logo_url,
                "website" => $this->brand->website,
            ],
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "detail" => [
                "weight" => $this->productDetail->weight,
                "dimensions" => json_decode($this->productDetail->dimensions),
                "materials" => $this->productDetail->materials,
                "country_of_origin" => $this->productDetail->country_of_origin,
                "warranty_info" => $this->productDetail->warranty_info,
                "care_instructions" => $this->productDetail->care_instructions,
                "additional_info" => json_decode($this->productDetail->additional_info)
            ],
            "price" => [
                "base_price" => $this->productPrice->base_price,
                "sale_price" => $this->productPrice->sale_price,
                "currency" => $this->productPrice->currency,
                "tax_rate" => $this->productPrice->tax_rate,
                "discount_percentage" => $this->productPrice->discount_percentage,
            ],
            "categories" => $this->productCategories->map(function ($item) {
                return [
                    "id" => $item->category->id,
                    "name" => $item->category->name,
                    "slug" => $item->category->slug,
                    "is_primary" => $item->category->praent_id !== null,
                    "parent" => [
                        "id" => $item->category->parentCategory->id,
                        "name" => $item->category->parentCategory->name,
                        "slug" => $item->category->parentCategory->slug,
                    ],
                ];
            }),
            "option_groups" => $this->productOptionGroups->map(function ($item) {
                return [
                    "id" => $item->id,
                    "name" => $item->name,
                    "display_order" => $item->display_order,
                    "options" => $item->productOptions->map(function ($item) {
                        return [
                            "id" => $item->id,
                            "name" => $item->name,
                            "additional_price" => $item->additional_price,
                            "sku" => $item->sku,
                            "stock" => $item->stock,
                            "display_order" => $item->display_order,
                        ];
                    })
                ];
            }),
            "images" => $this->productImages->map(function ($item) {
                return [
                    "id" => $item->id,
                    "url" => $item->url,
                    "alt_text" => $item->alt_text,
                    "is_primary" => $item->is_primary,
                    "display_order" => $item->display_order,
                    "option_id" => $item->option_id,
                ];
            }),
            "tags" => $this->productTags->map(function ($item) {
                return [
                    "id" => $item->tag->id,
                    "name" => $item->tag->name,
                    "slug" => $item->tag->slug,
                ];
            }),
            "rating" => [
                "average" => $this->reviewStats->average,
                "count" => $this->reviewStats->count,
                "distribution" => $this->reviewRatingDistribution->map(function ($item) {
                    return [
                        $item->rating => $item->count,
                    ];
                })->collapseWithkeys()->sortKeysDesc(),
            ],
            "related_products" => $this->relatedProducts->map(function ($item) {
                return [
                    "id" => $item->id,
                    "name" => $item->name,
                    "slug" => $item->slug,
                    "short_description" => $item->short_description,
                    "primary_image" => [
                        "url" => $item->productImages->first()->url,
                        "alt_text" => $item->productImages->first()->alt_text,
                    ],
                    "base_price" => $item->productPrice->base_price,
                    "sale_price" => $item->productPrice->sale_price,
                    "currency" => $item->productPrice->currency,
                ];
            }),
        ];
    }
}
