<?php

declare(strict_types=1);

namespace App\Adapter\Player;

use App\Eloquents\EloquentPlayer;
use TennisTrack\Player\UseCase\Ports\PlayerQueryPort;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\Player\Domain\Models\Id;
use TennisTrack\SportCategory\Domain\Models\Id as SportCategoryId;

class PlayerQueryAdapter implements PlayerQueryPort
{
    /**
     * @param EloquentPlayer $eloquentPlayer
     */
    public function __construct(
        private EloquentPlayer $eloquentPlayer
    ) {
        $this->eloquentPlayer = $eloquentPlayer;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchBySportCategoryId(SportCategoryId $sportCategoryId): array
    {
        $eloquentPlayers = $this->eloquentPlayer
            ->where('sport_category_id', $sportCategoryId->toInt())
            ->get();

        return $eloquentPlayers->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function getById(Id $id): TennisPlayer
    {
        $eloquentPlayer = $this->eloquentPlayer->find($id->toString());
        return TennisPlayer::fromArray($eloquentPlayer->toArray());
    }
}
