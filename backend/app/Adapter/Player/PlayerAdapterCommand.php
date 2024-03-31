<?php

declare(strict_types=1);

namespace App\Adapter\Player;

use App\Eloquents\EloquentTennisPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\Ports\PlayerAdapterCommandPort;

class PlayerAdapterCommand implements PlayerAdapterCommandPort
{
    /**
     * @param EloquentTennisPlayer $eloquentTennisPlayer
     */
    public function __construct(
        private EloquentTennisPlayer $eloquentTennisPlayer
    ) {
        $this->eloquentTennisPlayer = $eloquentTennisPlayer;
    }

    /**
     * {@inheritDoc}
     */
    public function upsertById(TennisPlayers $players): void
    {
        $playersArray = $players->toArray();
        $this->eloquentTennisPlayer->upsert($playersArray, ['id']);
    }
}
