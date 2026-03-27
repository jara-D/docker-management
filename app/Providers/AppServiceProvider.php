<?php

namespace App\Providers;

use App\Adapters\DockerAdapter;
use App\Adapters\GoServiceAdapter;
use App\Adapters\Interface\ContainerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContainerInterface::class, GoServiceAdapter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
