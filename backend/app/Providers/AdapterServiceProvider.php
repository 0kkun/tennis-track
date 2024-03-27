<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdapterServiceProvider extends ServiceProvider
{
    private const MODELS = [
        'Player',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (self::MODELS as $model) {
            $this->app->bind(
                "TennisTrack\{$model}\UseCase\Ports\{$model}AdapterCommandPort",
                "App\Adapter\{$model}\{$model}AdapterCommand"
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
