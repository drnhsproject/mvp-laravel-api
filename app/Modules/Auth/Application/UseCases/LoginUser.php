<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Models\User;
use App\Modules\Auth\Domain\Exceptions\AccountLockedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function execute(string $login, string $password): array
    {
        $loginField = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $login,
            'password' => $password
        ];

        if (!Auth::attempt($credentials)) {
            $this->handleFailure($loginField, $login);
        }

        /** @var User $user */
        $user = Auth::user(); // Cast to our User model which has HasApiTokens

        // Check lock (prevent login if active lock exists)
        if ($user->locked_until && $user->locked_until->isFuture()) {
            $seconds = $user->locked_until->diffInSeconds(now());
            throw new AccountLockedException("Your account is locked. Please try again in {$seconds} seconds.", $seconds);
        }

        $this->handleSuccess($user);

        // Eager load roles and their privileges
        $user->load('roles.privileges');

        $rolePrivileges = $user->roles->flatMap(function ($role) {
            return $role->privileges;
        })->unique('id')->values();

        // Clean up privileges relation from roles to avoid redundancy in the 'user' response object
        $user->roles->each(function ($role) {
            $role->unsetRelation('privileges');
        });

        // Token Configuration
        $accessTtl = (int) config('sanctum.access_token_ttl', 60);
        $refreshTtl = (int) config('sanctum.refresh_token_ttl', 60 * 24 * 14);

        $accessToken = $user->createToken('access_token', ['access-api'], now()->addMinutes($accessTtl));
        $refreshToken = $user->createToken('refresh_token', ['issue-access-token'], now()->addMinutes($refreshTtl));

        return [
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => $accessTtl * 60, // seconds
            'user' => $user,
            'role_privileges' => $rolePrivileges,
        ];
    }

    private function handleFailure(string $field, string $value): void
    {
        $user = User::where($field, $value)->first();
        if ($user) {
            if ($user->locked_until && $user->locked_until->isFuture()) {
                $seconds = $user->locked_until->diffInSeconds(now());
                throw new AccountLockedException("Your account is locked. Please try again in {$seconds} seconds.", $seconds);
            }

            $lockKey = 'login_attempt_lock_' . $user->id;
            if (!cache()->has($lockKey)) {
                $user->increment('login_attempts');
                cache()->put($lockKey, true, 10);

                $maxAttempts = (int) env('AUTH_MAX_ATTEMPTS', 3);
                if ($user->login_attempts >= $maxAttempts) {
                    $lockoutMinutes = (int) env('AUTH_LOCKOUT_MINUTES', 1);
                    $user->update(['locked_until' => now()->addMinutes($lockoutMinutes)]);
                    throw new AccountLockedException("Your account is locked due to too many failed attempts. Try again in {$lockoutMinutes} minute(s).", $lockoutMinutes * 60);
                }
            }
        }

        throw ValidationException::withMessages([
            'login' => ['Invalid credentials'],
        ]);
    }

    private function handleSuccess(User $user): void
    {
        $user->forceFill([
            'last_login_at' => now(),
            'login_attempts' => 0,
            'locked_until' => null,
        ])->save();

        $user->increment('login_count');
    }
}
