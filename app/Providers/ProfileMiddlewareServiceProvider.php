<?php

namespace App\Providers;

use App\Http\Middleware\EnsureProfileIsComplete;
use Illuminate\Support\ServiceProvider;

class ProfileMiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registrar el middleware con un alias
        $this->app->singleton('middleware.profile.complete', function () {
            return new EnsureProfileIsComplete;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registrar el middleware con el router
        $router = $this->app['router'];
        $router->aliasMiddleware('profile.complete', EnsureProfileIsComplete::class);
    }
}
