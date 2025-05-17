<?php

namespace App\CommandHandlers\Product;

use App\CommandHandlers\CommandHandlerInterface;
use App\Commands\Product\CreateProductCommand;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\DB;

class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function handler(CreateProductCommand $command)
    {
        DB::transaction(function () use ($command) {
            $product = new Product();
            $product->name = $command->name;
            $product->slug = $command->slug;
            $product->short_description = $command->shortDescription;
            $product->full_description = $command->fullDescription;
            $product->seller_id = $command->sellerId;
            $product->brand_id = $command->brandId;
            $product->status = $command->status;
            $product->save();

            $productId = $product->id;

//            $this->details = $dto->details;
//            $this->price = $dto->price;
//            $this->categories = $dto->categories;
//            $this->optionGroups = $dto->optionGroups;
//            $this->images = $dto->images;
//            $this->tags = $dto->tags;

            $productDetail = new ProductDetail();
            $productDetail->weight = $command->details['weight'];
            $productDetail->dimensions = json_encode($command->details['dimensions']);
            $productDetail->materials = $command->details['materials'];
            $productDetail->countryOrOrgin = $command->details['countryOrOrgin'];
        });

    }
}