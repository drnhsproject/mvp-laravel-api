<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Auth\Presentation\Requests\LoginRequest;
use App\Modules\Auth\Presentation\Requests\RegisterRequest;
use App\Modules\Auth\Application\UseCases\LoginUser;
use App\Modules\Auth\Application\UseCases\RegisterUser;
use App\Modules\User\Presentation\Resources\UserResource;

class AuthController extends Controller
{
    public function __construct(
        protected LoginUser $loginUser,
        protected RegisterUser $registerUser
    ) {}

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->registerUser->execute($request->validated());

        return response()->json([
            'message' => 'user registered successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user in and issue a token.
     */
    public function login(LoginRequest $request)
    {
        $result = $this->loginUser->execute($request->login, $request->password);

        return response()->json([
            'user' => new UserResource($result['user']),
            'permissions' => $result['role_privileges']->map(function ($privilege) {
                return [
                    'code' => $privilege->code,
                    'module' => $privilege->module,
                    'action' => $privilege->action,
                    'namespace' => $privilege->namespace,
                ];
            })->values(),
            'access_token' => $result['access_token'],
            'token_type' => $result['token_type'],
        ]);
    }

    /**
     * Log the user out (revoke the token).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'successfully logged out']);
    }
}
