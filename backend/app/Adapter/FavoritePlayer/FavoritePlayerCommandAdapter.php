<?php

declare(strict_types=1);

namespace App\Adapter\FavoritePlayer;

use App\Eloquents\EloquentFavoritePlayer;
use TennisTrack\FavoritePlayer\Domain\Models\FavoritePlayers;
use TennisTrack\FavoritePlayer\Domain\Models\Id as FavoritePlayerId;
use TennisTrack\FavoritePlayer\UseCase\Ports\FavoritePlayerCommandPort;
use TennisTrack\User\Domain\Models\Id as UserId;

class FavoritePlayerCommandAdapter implements FavoritePlayerCommandPort
{
    /**
     * @param EloquentFavoritePlayer $eloquentFavoritePlayer
     */
    public function __construct(
        private EloquentFavoritePlayer $eloquentFavoritePlayer
    ) {
        $this->eloquentFavoritePlayer = $eloquentFavoritePlayer;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(FavoritePlayerId $id): void
    {
        $this->eloquentFavoritePlayer->find($id->toInt())->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function fetchByUserId(UserId $userId): FavoritePlayers
    {
        $favoritePlayers = $this->eloquentFavoritePlayer
            ->with('player')
            ->where('user_id', $userId->toInt())
            ->get()
            ->toArray();

        return FavoritePlayers::fromArray($favoritePlayers);
    }
}
