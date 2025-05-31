<?php

namespace App\Http\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Product\ProductCollectionResource;
use App\Http\Resources\Product\ProductResource;
use App\Queries\Product\GetProductByIdQuery;
use App\Queries\Product\GetProductsQuery;
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

    public function index(Request $request)
    {
        $query = new GetProductsQuery(
            page: $request->query('page', 1),
            perPage: $request->query('perPage', 10),
            sort: $request->query('sort', 'created_at:desc'),
            status: $request->query('status'),
            minPrice: $request->query('minPrice'),
            maxPrice: $request->query('maxPrice'),
            categoryId: $request->query('category', []),
            sellerId: $request->query('seller'),
            brandId: $request->query('brand'),
            inStock: $request->query('inStock'),
            search: $request->query('search'),
        );

        $products = $this->queryBus->dispatch($query);
        return response()->json([
            'success' => true,
            'data' => new ProductCollectionResource($products),
            "message" => "상품 목록을 성공적으로 조회했습니다."
        ]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $command = $request->toCreateProductCommand();
        $product = $this->commandBus->dispatch($command);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => '상품이 성공적으로 등록되었습니다.'
        ]);

    }

    public function show(int $id): JsonResponse
    {
        $query = new GetProductByIdQuery($id);
        $product = $this->queryBus->dispatch($query);

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
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
