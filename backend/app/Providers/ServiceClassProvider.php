<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceClassProvider extends ServiceProvider
{
    private const PREFIXES = [
        '',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (self::PREFIXES as $prefix) {
            $this->app->bind(
                "App\Services\Interfaces\\{$prefix}ServiceInterface",
                "App\Services\\{$prefix}Service"
            );
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
