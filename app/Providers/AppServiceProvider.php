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
        // Don't register middleware bindings in the IoC container here.
        // Middleware aliases are defined in `app/Http/Kernel.php` and
        // are resolved by the router. Registering middleware in the
        // container as a service can lead to the container trying to
        // resolve aliases as class names (e.g. 'permission') and causing
        // "Target class [permission] does not exist" errors.
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
