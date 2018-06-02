<?php

namespace ElicDev\SiteProtection;

use Illuminate\Support\ServiceProvider;

class SiteProtectionServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'site-protection');

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/site-protection'),
        ], 'views');

        $this->publishes([
            __DIR__.'/config' => config_path(''),
        ], 'config');
    }
}
