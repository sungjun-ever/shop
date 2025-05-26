<?php

namespace App\CommandHandlers\Product;

use App\CommandHandlers\CommandHandlerInterface;
use App\Commands\Product\CreateProductCommand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductOption;
use App\Models\ProductOptionGroup;
use App\Models\ProductPrice;
use App\Models\ProductTag;
use Illuminate\Support\Facades\DB;

class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function handler(CreateProductCommand $command): array
    {
        return DB::transaction(function () use ($command) {
            $product = $this->createProduct($command);
            $this->createProductDetail($command, $product['id']);
            $this->createProductPrice($command, $product['id']);
            $this->createProductCategories($command, $product['id']);
            $this->createProductOptionGroups($command, $product['id']);
            $this->createProductImage($command, $product['id']);
            $this->createProductTag($command, $product['id']);

            return $product;
        });
    }

    private function createProduct($command): array
    {
        $product = new Product();
        $product->name = $command->name;
        $product->slug = $command->slug;
        $product->short_description = $command->shortDescription;
        $product->full_description = $command->fullDescription;
        $product->seller_id = $command->sellerId;
        $product->brand_id = $command->brandId;
        $product->status = $command->status;
        $product->save();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];
    }

    private function createProductDetail($command, $productId): void
    {
        if ($command->details) {
            $productDetail = new ProductDetail();
            $productDetail->product_id = $productId;
            $productDetail->weight = $command->details->weight;
            $productDetail->dimensions = json_encode($command->details->dimensions);
            $productDetail->materials = $command->details->materials;
            $productDetail->countryOfOrigin = $command->details->countryOfOrigin;
            $productDetail->save();
        }
    }

    private function createProductPrice($command, $productId): void
    {
        if ($command->price) {
            $productPrice = new ProductPrice();
            $productPrice->product_id = $productId;
            $productPrice->base_price = $command->price->basePrice;
            $productPrice->sale_price = $command->price->salePrice;
            $productPrice->cost_price = $command->price->costPrice;
            $productPrice->currency = $command->price->currency;
            $productPrice->tax_rate = $command->price->taxRate;
            $productPrice->save();
        }
    }

    private function createProductCategories($command, $productId): void
    {
        if (count($command->categories) > 0) {
            foreach ($command->categories as $category) {
                $insertCategory = new ProductCategory();
                $insertCategory->product_id = $productId;
                $insertCategory->category_id = $category->categoryId;
                $insertCategory->is_primary = $category->isPrimary;
                $insertCategory->save();
            }
        }
    }

    private function createProductOptionGroups($command, $productId): void
    {
        if (count($command->optionGroups) > 0) {
            foreach ($command->optionGroups as $optionGroup) {
                $insertOptionGroup = new ProductOptionGroup();
                $insertOptionGroup->product_id = $productId;
                $insertOptionGroup->name = $optionGroup->name;
                $insertOptionGroup->display_order = $optionGroup->displayOrder;
                $insertOptionGroup->save();

                $optionGroupId = $insertOptionGroup->id;

                $this->createProductOption($optionGroup, $optionGroupId);
            }
        }
    }

    private function createProductOption($optionGroup, $optionGroupId): void
    {
        if (count($optionGroup->options) > 0) {
            foreach ($optionGroup->options as $option) {
                $insertOption = new ProductOption();
                $insertOption->option_group_id = $optionGroupId;
                $insertOption->name = $option->name;
                $insertOption->additional_price = $option->additionalPrice;
                $insertOption->sku = $option->sku;
                $insertOption->stock = $option->stock;
                $insertOption->display_order = $option->displayOrder;
                $insertOption->save();
            }
        }
    }

    private function createProductImage($command, $productId): void
    {
        if (count($command->images) > 0) {
            foreach ($command->images as $image) {
                $productImage = new ProductImage();
                $productImage->product_id = $productId;
                $productImage->url = $image->url;
                $productImage->alt_text = $image->altText;
                $productImage->is_primary = $image->isPrimary;
                $productImage->display_order = $image->displayOrder;
                $productImage->option_id = $image->optionId;
                $productImage->save();
            }
        }
    }

    private function createProductTag($command, $productId): void
    {
        if (count($command->tags) > 0) {
            foreach ($command->tags as $tagId) {
                $productTag = new ProductTag();
                $productTag->product_id = $productId;
                $productTag->tag_id = $tagId;
            }
        }
    }
}