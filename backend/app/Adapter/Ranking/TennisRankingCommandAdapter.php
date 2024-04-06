<?php

declare(strict_types=1);

namespace App\Adapter\Ranking;

use App\Eloquents\EloquentTennisRanking;
use TennisTrack\Ranking\Domain\Models\TennisRankings;
use TennisTrack\Ranking\UseCase\Ports\TennisRankingCommandPort;

class TennisRankingCommandAdapter implements TennisRankingCommandPort
{
    /**
     * @param EloquentTennisRanking $eloquentTennisRanking
     */
    public function __construct(
        private EloquentTennisRanking $eloquentTennisRanking
    ) {
        $this->eloquentTennisRanking = $eloquentTennisRanking;
    }

    /**
     * {@inheritDoc}
     */
    public function upsert(TennisRankings $rankings): void
    {
        $rankingsArray = $rankings->toArray();
        $this->eloquentTennisRanking->upsert($rankingsArray, ['ranking_date']);
    }
}
