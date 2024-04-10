<?php

declare(strict_types=1);

namespace App\Adapter\Ranking;

use App\Eloquents\EloquentTennisRanking;
use TennisTrack\Ranking\Domain\Models\TennisRankings;
use TennisTrack\Ranking\UseCase\Ports\TennisRankingQueryPort;
use TennisTrack\Ranking\Domain\Models\RankingDate;

class TennisRankingQueryAdapter implements TennisRankingQueryPort
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
    public function getLatestRankingDate(): RankingDate
    {
        return RankingDate::from($this->eloquentTennisRanking->max('ranking_date'));
    }

    /**
     * {@inheritDoc}
     */
    public function fetchForLatest(): TennisRankings
    {
        $latestDate = $this->getLatestRankingDate()->toDateString();
        $eloquentTennisRankings = $this->eloquentTennisRanking
            ->where('ranking_date', $latestDate)
            ->orderBy('rank')
            ->limit(100)
            ->get();
        $rankings = TennisRankings::fromArray($eloquentTennisRankings->toArray());

        return $rankings;
    }
}
