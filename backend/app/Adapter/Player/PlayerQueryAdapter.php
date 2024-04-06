<?php

declare(strict_types=1);

namespace App\Adapter\Player;

use App\Eloquents\EloquentPlayer;
use TennisTrack\Player\UseCase\Ports\PlayerQueryPort;

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
    public function fetchBySportCategoryId(int $sportCategoryId): array
    {
        $eloquentPlayers = $this->eloquentPlayer
            ->where('sport_category_id', $sportCategoryId)
            ->get();

        return $eloquentPlayers->toArray();
    }
}
