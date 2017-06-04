<?php

namespace ElicDev\SiteProtection;

use Illuminate\Support\ServiceProvider;

class SiteProtectionServiceProvider extends ServiceProvider
{
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
    }
}
