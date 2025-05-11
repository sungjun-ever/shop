<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // 메인 페이지 상품 및 카테고리
    Route::get('/main', []);

    Route::prefix('products')->group(function () {
        // 상품 목록 조회
        Route::get('/', []);
        // 상품 등록
        Route::post('/', []);
        // 상품 상세 조회
        Route::get('/{productId}', [])
            ->where('productId', '[0-9]+');
        // 상품 수정
        Route::put('/{productId}', [])
            ->where('productId', '[0-9]+');
        // 상품 삭제
        Route::delete('/{productId}', [])
            ->where('productId', '[0-9]+');
        // 상품 이미지 등록
        Route::post('/{productId}/images')
            ->where('productId', '[0-9]+');
        // 상품 리뷰
        Route::get('/{productId}/reviews', [])
            ->where('productId', '[0-9]+');
        // 상품 리뷰 등록
        Route::post('/{productId}/reviews', [])
            ->where('productId', '[0-9]+');
        // 상품 옵션 추가
        Route::post('/{productId}/options', [])
            ->where('productId', '[0-9]+');
        // 상품 옵션 수정
        Route::put('/{productId}/options/{optionId}', [])
            ->where(['productId' => '[0-9]+', 'optionId' => '[0-9]+']);
        // 상품 옵션 삭제
        Route::delete('/{productId}/options/{optionId}', [])
            ->where(['productId' => '[0-9]+', 'optionId' => '[0-9]+']);
    });

    Route::prefix('categories')->group(function () {
        // 카테고리 목록 조회
        Route::get('/', []);
        // 특정 카테고리 상품 목록 조회
        Route::get('/{categoryId}/products', [])
            ->where('categoryId', '[0-9]+');
    });

    // 리뷰 수정
    Route::put('/reviews/{reviewId}', [])
        ->where('reviewId', '[0-9]+');
    Route::delete('/reviews/{reviewId}', [])
        ->where('reviewId', '[0-9]+');


})->middleware('auth:sanctum');