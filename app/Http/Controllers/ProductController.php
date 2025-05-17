<?php

namespace App\Http\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Queries\Product\GetProductByIdQuery;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus   $queryBus
    )
    {
    }

    public function index()
    {

    }

    public function store()
    {

    }

    public function show(int $id)
    {
        $query = new GetProductByIdQuery($id);
        $product = $this->queryBus->dispatch($query);

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function productReviews()
    {

    }
}
