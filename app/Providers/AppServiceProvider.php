<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production or Railway deployment
        if ($this->app->environment('production') || str_contains(config('app.url', ''), 'railway.app')) {
            URL::forceScheme('https');
        }
    }
}
