<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase;

use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\Ports\PlayerCommandPort;

class UpsertPlayer
{
    /**
     * @param PlayerCommandPort $playerCommand
     */
    public function __construct(
        private PlayerCommandPort $playerCommand
    ) {
        $this->playerCommand = $playerCommand;
    }

    /**
     * @param TennisPlayers $players
     * @return void
     */
    public function execute(TennisPlayers $players): void
    {
        $this->playerCommand->upsertByKeys($players, ['id']);
    }
}
