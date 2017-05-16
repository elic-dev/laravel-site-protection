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
    }
}
