<?php

namespace App\Providers;

use App\Domains\User\Repositories\EloquentUserRepository;
use App\Domains\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(App\Domains\User\Repositories\UserRepositoryInterface::class, App\Domains\User\Repositories\EloquentUserRepository::class);
        // $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
           $this->loadMigrationsFrom(base_path('app/Domains/User/Database/Migrations'));

    }
}
