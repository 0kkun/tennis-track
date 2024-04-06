<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\UseCase;

use TennisTrack\Ranking\Domain\Models\TennisRankings;
use TennisTrack\Ranking\UseCase\Ports\TennisRankingCommandPort;

class InsertTennisRanking
{
    /**
     * @param TennisRankingCommandPort $tennisRankingAdapterCommand
     */
    public function __construct(
        private TennisRankingCommandPort $tennisRankingCommand
    ) {
        $this->tennisRankingCommand = $tennisRankingCommand;
    }

    /**
     * @param TennisRankings $rankings
     * @return void
     */
    public function execute(TennisRankings $rankings): void
    {
        $this->tennisRankingCommand->upsert($rankings);
    }
}
