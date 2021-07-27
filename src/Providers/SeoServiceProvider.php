<?php

namespace Davut\Seo\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Davut\Seo\Services\SeoService;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/seo.php', 'seo');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'seo');

        $this->publishes([
            dirname(__DIR__) . '/../config/seo.php' => config_path('seo.php'),
        ], 'config');

        $this->publishes([
            dirname(__DIR__) . '/../resources/views' => resource_path('views/vendor/seo'),
        ], 'views');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/../config/seo.php',
            'seo'
        );

        $this->app->bind(SeoService::class, function (Application $app) {
            return new SeoService;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [SeoService::class];
    }
}
