<?php

namespace Feadbox\Seo;

use Illuminate\Support\ServiceProvider;
use Feadbox\Seo\Services\SeoService;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/seo.php', 'seo');

        $this->app->singleton(SeoService::class, function () {
            return new SeoService;
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/seo.php' => config_path('seo.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/seo'),
            ], 'views');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'seo');
    }
}
