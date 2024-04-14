<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\UseCase;

use TennisTrack\Ranking\Domain\Models\TennisRankings;
use TennisTrack\Ranking\UseCase\Ports\TennisRankingQueryPort;

class GetTennisRankings
{
    /**
     * @param TennisRankingQueryPort $rankingQuery
     */
    public function __construct(
        private TennisRankingQueryPort $rankingQuery
    ) {
        $this->rankingQuery = $rankingQuery;
    }

    /**
     * @return TennisRankings
     */
    public function execute(): TennisRankings
    {
        $rankings = $this->rankingQuery->fetchForLatest();

        return $rankings;
    }
}
