<?php

declare(strict_types=1);

namespace TennisTrack\FavoritePlayer\UseCase\Ports;

use TennisTrack\FavoritePlayer\Domain\Models\FavoritePlayers;
use TennisTrack\User\Domain\Models\Id as UserId;
use TennisTrack\FavoritePlayer\Domain\Models\Id as FavoritePlayerId;

interface FavoritePlayerCommandPort
{
    /**
     * @param FavoritePlayerId $id
     * @return void
     */
    public function deleteById(FavoritePlayerId $id): void;

    /**
     * @param UserId $userId
     * @return FavoritePlayers
     */
    public function fetchByUserId(UserId $userId): FavoritePlayers;
}
