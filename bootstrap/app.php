<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(
                    [
                        'success' => false,
                        'error' => [
                            'code' => 'RESOURCE_NOT_FOUND',
                            'message' => '요청 리소스를 찾을 수 없습니다.',
                            'details' => [],
                        ]
                    ], 404
                );
            }
        });

        $exceptions->render(function (InvalidArgumentException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(
                    [
                        'success' => false,
                        'error' => [
                            'code' => 'INVALID_ARGUMENT',
                            'message' => '잘못된 입력 데이터',
                            'details' => [],
                        ],

                    ],
                    400
                );
            }

        });

        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(
                    [
                        'success' => false,
                        'error' => [
                            'code' => 'INTERNAL_ERROR',
                            'message' => '서버 내부 오류',
                            'details' => [],
                        ],
                    ],
                    500
                );
            }
        });
    })->create();
