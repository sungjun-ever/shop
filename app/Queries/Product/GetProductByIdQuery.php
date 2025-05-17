<?php

namespace App\Queries\Product;

use App\Queries\QueryInterface;

class GetProductByIdQuery implements QueryInterface
{
    public int $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }


}