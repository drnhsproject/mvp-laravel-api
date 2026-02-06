<?php

use App\Http\Controllers\Api\AuthController;
use App\Modules\Privilege\Presentation\Controllers\PrivilegeController;
use App\Modules\Role\Presentation\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Modules\User\Presentation\Controllers\UserController;
use App\Modules\SysParams\Presentation\Controllers\SystemParameterController;

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

        Route::apiResource('privileges', PrivilegeController::class)
            ->names([
                'index' => 'privilege.list',
                'show' => 'privilege.detail',
                'store' => 'privilege.create',
                'update' => 'privilege.update',
                'destroy' => 'privilege.delete',
            ])
            ->middleware('check.permission');

        Route::get('sysparams/groups/{group}', [SystemParameterController::class, 'getOptions'])
            ->name('sysparam.options')
            ->middleware('check.permission');

        Route::apiResource('sysparams', SystemParameterController::class)
            ->names([
                'index' => 'sysparam.list',
                'show' => 'sysparam.detail',
                'store' => 'sysparam.create',
                'update' => 'sysparam.update',
                'destroy' => 'sysparam.delete',
            ])
            ->middleware('check.permission');

        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
