<?php

namespace Feadbox\Seo\Providers;

use Illuminate\Support\ServiceProvider;
use Feadbox\Seo\Services\SeoService;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'seo');

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
        $this->mergeConfigFrom(dirname(__DIR__) . '/../config/seo.php', 'seo');

        $this->app->singleton(SeoService::class, function () {
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
