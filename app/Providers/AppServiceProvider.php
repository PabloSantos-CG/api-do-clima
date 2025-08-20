<?php

namespace App\Providers;

use App\Infrastructure\CacheRepositoryInterface;
use App\Infrastructure\RedisCacheRepository;
use Illuminate\Support\ServiceProvider;


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
