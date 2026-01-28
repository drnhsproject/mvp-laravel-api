<?php

use App\Http\Controllers\Api\AuthController;
use App\Modules\Role\Presentation\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Modules\User\Presentation\Controllers\UserController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);

// Protected routes
Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', UserController::class)
            ->names([
                'index' => 'user.list',
                'show' => 'user.detail',
                'store' => 'user.create',
                'update' => 'user.update',
                'destroy' => 'user.delete',
            ])
            ->middleware('check.permission');

        Route::apiResource('roles', RoleController::class)
            ->names([
                'index' => 'role.list',
                'show' => 'role.detail',
                'store' => 'role.create',
                'update' => 'role.update',
                'destroy' => 'role.delete',
            ])
            ->middleware('check.permission');

        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
