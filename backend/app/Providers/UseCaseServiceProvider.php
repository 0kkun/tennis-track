<?php

namespace App\Providers;

use App\Adapter\Player\PlayerCommandAdapter;
use App\Adapter\Player\PlayerQueryAdapter;
use App\Adapter\Ranking\TennisRankingCommandAdapter;
use Illuminate\Support\ServiceProvider;
use TennisTrack\Player\UseCase\GetTennisPlayerList;
use TennisTrack\Player\UseCase\UpsertPlayer;
use TennisTrack\Ranking\UseCase\UpsertTennisRanking;

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
                $app->make(PlayerCommandAdapter::class)
            );
        });
        $this->app->bind(GetTennisPlayerList::class, function ($app) {
            return new GetTennisPlayerList(
                $app->make(PlayerQueryAdapter::class)
            );
        });

        // Ranking
        $this->app->bind(UpsertTennisRanking::class, function ($app) {
            return new UpsertTennisRanking(
                $app->make(TennisRankingCommandAdapter::class)
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
