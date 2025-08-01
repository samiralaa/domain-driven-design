<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CustomCacheManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CustomCacheManager::class, function () {
            return new CustomCacheManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
