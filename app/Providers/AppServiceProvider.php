<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (in_array(\Request::ip(), ['127.0.0.1', '80.154.74.243'])) {
            config(['app.debug' => true]);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        error_reporting(0);

        setlocale(LC_ALL, config('app.locale'));

        Paginator::useBootstrap();
    }
}
