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
        // $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
