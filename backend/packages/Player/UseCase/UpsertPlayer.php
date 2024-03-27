<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase;

use TennisTrack\Player\Domain\Models\Players;
use TennisTrack\Player\UseCase\Ports\PlayerAdapterCommandPort;

final class UpsertPlayer
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
     * @param Players $players
     * @return void
     */
    public function execute(Players $players): void
    {
        $this->playerAdapterCommand->upsertById($players);
    }
}
