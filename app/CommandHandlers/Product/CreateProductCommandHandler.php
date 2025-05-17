<?php

namespace App\CommandHandlers\Product;

use App\CommandHandlers\CommandHandlerInterface;
use App\Commands\Product\CreateProductCommand;
use App\Models\Product;

class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function handler(CreateProductCommand $command)
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
    }
}