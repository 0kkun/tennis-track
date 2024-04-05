<?php

declare(strict_types=1);

namespace App\Adapter\Player;

use App\Eloquents\EloquentPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\Ports\PlayerAdapterCommandPort;

class PlayerAdapterCommand implements PlayerAdapterCommandPort
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

    /**
     * {@inheritDoc}
     */
    public function upsertByKeys(TennisPlayers $players, array $keys): void
    {
        $playersArray = $players->toArray();
        $this->eloquentPlayer->upsert($playersArray, $keys);
    }
}
