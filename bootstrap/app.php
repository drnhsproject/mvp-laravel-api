<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function ($request, $e) {
            return $request->is('api/*') || $request->wantsJson();
        });

        $exceptions->render(function (Throwable $e, $request) {
            if (!$request->is('api/*') && !$request->wantsJson()) {
                return null; // Default handling for non-API
            }

            $statusCode = 500;
            $message = $e->getMessage();

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }

            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $statusCode = $e->getStatusCode();
                $message = $e->getMessage() ?: \Symfony\Component\HttpFoundation\Response::$statusTexts[$statusCode];
            } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
                $statusCode = 401;
                $message = 'Unauthenticated';
            } elseif ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $statusCode = 404;
                $message = 'Resource not found';
            } elseif ($e instanceof \App\Modules\Auth\Domain\Exceptions\AccountLockedException) {
                $statusCode = 429;
                // message is already in exception
            }

            // Standardize generic response
            return response()->json([
                'status_code' => $statusCode,
                'message' => $message,
            ], $statusCode);
        });
    })->create();
