<?php

namespace App\Modules\Auth\Application\UseCases;

use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;

class RefreshToken
{
    public function execute(string $refreshToken)
    {
        $token = PersonalAccessToken::findToken($refreshToken);

        if (! $token || ! $token->can('issue-access-token')) {
            throw ValidationException::withMessages([
                'refresh_token' => ['Invalid or expired refresh token.'],
            ]);
        }

        // Optional: Check expiration manually if not handled by Sanctum
        if ($token->expires_at && $token->expires_at->isPast()) {
            throw ValidationException::withMessages([
                'refresh_token' => ['Invalid or expired refresh token.'],
            ]);
        }

        $user = $token->tokenable;

        if (! $user) {
            throw ValidationException::withMessages([
                'refresh_token' => ['User not found.'],
            ]);
        }

        // Revoke the old refresh token (Rotation)
        $token->delete();

        // Issue new pair
        $accessTtl = (int) config('sanctum.access_token_ttl', 60);
        $refreshTtl = (int) config('sanctum.refresh_token_ttl', 60 * 24 * 14);

        $newAccessToken = $user->createToken('access_token', ['access-api'], now()->addMinutes($accessTtl));
        $newRefreshToken = $user->createToken('refresh_token', ['issue-access-token'], now()->addMinutes($refreshTtl));

        return [
            'access_token' => $newAccessToken->plainTextToken,
            'refresh_token' => $newRefreshToken->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => $accessTtl * 60,
        ];
    }
}
