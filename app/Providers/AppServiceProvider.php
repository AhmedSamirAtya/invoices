<?php

namespace App\Providers;

use App\Http\Middleware\IsActive;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middleware\RoleMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('role', function ($app) {
            return new RoleMiddleware($app['auth'], $app['router']);
        });
        $this->app->singleton('is_active', function ($app) {
            // You generally need to resolve it or just return the instance
            return new IsActive();
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
