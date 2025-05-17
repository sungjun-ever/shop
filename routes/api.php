<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductOptionController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // 메인 페이지 상품 및 카테고리
    Route::get('/main', [MainController::class, 'index']);;

    Route::prefix('products')->group(function () {
        // 상품 목록 조회
        Route::get('/', [ProductController::class, 'index'] );
        // 상품 등록
        Route::post('/', [ProductController::class, 'store']);
        // 상품 상세 조회
        Route::get('/{productId}', [ProductController::class, 'show'])
            ->where('productId', '[0-9]+');
        // 상품 수정
        Route::put('/{productId}', [ProductController::class, 'update'])
            ->where('productId', '[0-9]+');
        // 상품 삭제
        Route::delete('/{productId}', [ProductController::class, 'destroy'])
            ->where('productId', '[0-9]+');
        // 상품 이미지 등록
        Route::post('/{productId}/images', [ProductImageController::class, 'store'])
            ->where('productId', '[0-9]+');
        // 상품 리뷰
        Route::get('/{productId}/reviews', [ProductController::class, 'productReviews'])
            ->where('productId', '[0-9]+');
        // 상품 리뷰 등록
        Route::post('/{productId}/reviews', [ReviewController::class, 'store'])
            ->where('productId', '[0-9]+');
        // 상품 옵션 추가
        Route::post('/{productId}/options', [ProductOptionController::class, 'store'])
            ->where('productId', '[0-9]+');
        // 상품 옵션 수정
        Route::put('/{productId}/options/{optionId}', [ProductOptionController::class, 'update'])
            ->where(['productId' => '[0-9]+', 'optionId' => '[0-9]+']);
        // 상품 옵션 삭제
        Route::delete('/{productId}/options/{optionId}', [ProductOptionController::class, 'destroy'])
            ->where(['productId' => '[0-9]+', 'optionId' => '[0-9]+']);
    });

    Route::prefix('categories')->group(function () {
        // 카테고리 목록 조회
        Route::get('/', [CategoryController::class, 'index']);
        // 특정 카테고리 상품 목록 조회
        Route::get('/{categoryId}/products', [CategoryController::class, 'categoryProducts'])
            ->where('categoryId', '[0-9]+');
    });

    // 리뷰 수정
    Route::put('/reviews/{reviewId}', [ReviewController::class, 'update'])
        ->where('reviewId', '[0-9]+');
    // 리뷰 삭제
    Route::delete('/reviews/{reviewId}', [ReviewController::class, 'destroy'])
        ->where('reviewId', '[0-9]+');
})->withoutMiddleware('auth:sanctum');