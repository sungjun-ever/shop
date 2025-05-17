<?php

namespace App\Http\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Commands\Product\CreateProductCommand;
use App\DTO\Product\CreateProductDTO;
use App\Http\Requests\Product\StoreProductRequest;
use App\Queries\Product\GetProductByIdQuery;
use Illuminate\Http\JsonResponse;
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

    public function store(StoreProductRequest $request): JsonResponse
    {
        $command = $request->toCreateProductCommand();
        $productId = $this->commandBus->dispatch($command);

        return response()->json([
            'success' => true,
            'data' => $productId,
            'message' => '제품이 등록됐습니다.'
        ]);

    }

    public function show(int $id): JsonResponse
    {
        $query = new GetProductByIdQuery($id);
        $product = $this->queryBus->dispatch($query);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => '요청이 성공적으로 처리되었습니다.'
        ]);
    }

    public function update(): JsonResponse
    {

    }

    public function destroy(): JsonResponse
    {

    }

    public function productReviews(): JsonResponse
    {

    }
}
