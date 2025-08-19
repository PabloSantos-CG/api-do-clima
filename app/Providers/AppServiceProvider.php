<?php

namespace App\Providers;

use CacheRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use RedisCacheRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            CacheRepositoryInterface::class,
            RedisCacheRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
