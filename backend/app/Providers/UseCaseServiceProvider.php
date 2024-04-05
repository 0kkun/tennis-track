<?php

namespace App\Providers;

use App\Adapter\Player\PlayerAdapterCommand;
use App\Adapter\Ranking\TennisRankingAdapterCommand;
use Illuminate\Support\ServiceProvider;
use TennisTrack\Player\UseCase\GetTennisPlayer;
use TennisTrack\Player\UseCase\UpsertPlayer;
use TennisTrack\Ranking\UseCase\InsertTennisRanking;

class UseCaseServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        // Player
        $this->app->bind(UpsertPlayer::class, function ($app) {
            return new UpsertPlayer(
                $app->make(PlayerAdapterCommand::class)
            );
        });
        $this->app->bind(GetTennisPlayer::class, function ($app) {
            return new GetTennisPlayer(
                $app->make(PlayerAdapterCommand::class)
            );
        });

        // Ranking
        $this->app->bind(InsertTennisRanking::class, function ($app) {
            return new InsertTennisRanking(
                $app->make(TennisRankingAdapterCommand::class)
            );
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
    }
}
