<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase;

use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\Ports\PlayerAdapterCommandPort;

class GetTennisPlayer
{
    /**
     * @param PlayerAdapterCommandPort $playerAdapterCommand
     */
    public function __construct(
        private PlayerAdapterCommandPort $playerAdapterCommand
    ) {
        $this->playerAdapterCommand = $playerAdapterCommand;
    }

    /**
     * @param TennisPlayers $players
     * @return TennisPlayers
     */
    public function execute(): TennisPlayers
    {
        $sportCategoryId = 1;
        $players = $this->playerAdapterCommand->fetchBySportCategoryId($sportCategoryId);

        return $players;
    }
}
