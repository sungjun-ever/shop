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
        $product = Product::find($query->id);

        if (!$product) {
            throw new ModelNotFoundException($query->id . ' not found');
        }
        return $product;
    }
}