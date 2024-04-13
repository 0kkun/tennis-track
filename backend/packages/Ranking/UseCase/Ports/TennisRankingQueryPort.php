<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\UseCase\Ports;

use TennisTrack\Ranking\Domain\Models\RankingDate;
use TennisTrack\Ranking\Domain\Models\TennisRankings;

interface TennisRankingQueryPort
{
    /**
     * @return RankingDate
     */
    public function getLatestRankingDate(): RankingDate;

    /**
     * @return TennisRankings
     */
    public function fetchForLatest(): TennisRankings;
}
