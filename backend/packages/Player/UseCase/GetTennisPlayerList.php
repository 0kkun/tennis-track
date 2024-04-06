<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase;

use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\Ports\PlayerQueryPort;

class GetTennisPlayerList
{
    /**
     * @param PlayerQueryPort $playerQuery
     */
    public function __construct(
        private PlayerQueryPort $playerQuery
    ) {
        $this->playerQuery = $playerQuery;
    }

    /**
     * @param TennisPlayers $players
     * @return array
     */
    public function execute(): array
    {
        $sportCategoryId = 1;
        $players = $this->playerQuery->fetchBySportCategoryId($sportCategoryId);

        return $players;
    }
}
