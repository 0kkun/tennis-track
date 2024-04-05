<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\UseCase\Ports;

use TennisTrack\Ranking\Domain\Models\TennisRankings;

interface TennisRankingAdapterCommandPort
{
    public function upsert(TennisRankings $rankings): void;
}
