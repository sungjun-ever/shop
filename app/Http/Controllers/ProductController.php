<?php

namespace App\Http\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\DTO\Product\CreateProductDTO;
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

    public function store(Request $request)
    {
        $product = new CreateProductDTO(
            name: $request->name,
            slug: $request->slug,
            shortDescription: $request->shortDescription,
            fullDescription: $request->fullDescription,
            sellerId: $request->sellerId,
            brandId: $request->brandId,
            status: $request->status,
            details: $request->details,
            price: $request->price,
            categories: $request->categories,
            optionGroups: $request->optionGroups,
            images: $request->images,
            tags: $request->tags
        );

    }

    public function show(int $id)
    {
        $query = new GetProductByIdQuery($id);
        $product = $this->queryBus->dispatch($query);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => '요청이 성공적으로 처리되었습니다.'
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
