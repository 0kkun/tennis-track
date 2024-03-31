<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase;

use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\Ports\PlayerAdapterCommandPort;

class UpsertPlayer
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
     * @return void
     */
    public function execute(TennisPlayers $players): void
    {
        $this->playerAdapterCommand->upsertById($players);
    }
}
