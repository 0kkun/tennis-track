<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\UseCase;

use TennisTrack\Ranking\Domain\Models\TennisRankings;
use TennisTrack\Ranking\UseCase\Ports\TennisRankingAdapterCommandPort;

class InsertTennisRanking
{
    /**
     * @param TennisRankingAdapterCommandPort $tennisRankingAdapterCommand
     */
    public function __construct(
        private TennisRankingAdapterCommandPort $tennisRankingAdapterCommand
    ) {
        $this->tennisRankingAdapterCommand = $tennisRankingAdapterCommand;
    }

    /**
     * @param TennisRankings $rankings
     * @return void
     */
    public function execute(TennisRankings $rankings): void
    {
        $this->tennisRankingAdapterCommand->upsert($rankings);
    }
}
