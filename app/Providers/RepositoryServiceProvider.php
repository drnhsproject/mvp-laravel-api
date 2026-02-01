<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Modules\User\Infrastructure\Persistence\Repositories\PostgresUserRepository;
use App\Modules\SysParams\Domain\Contracts\SystemParameterRepositoryInterface;
use App\Modules\SysParams\Infrastructure\Persistence\Repositories\PostgresSystemParameterRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, PostgresUserRepository::class);
        $this->app->bind(SystemParameterRepositoryInterface::class, PostgresSystemParameterRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
