<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\Domain\Models;

use Carbon\Carbon;
use TennisTrack\Common\ValueObject\ValueObjectDatetime;

final class RankingDate
{
    use ValueObjectDatetime;

    /**
     * @param \Carbon|null $value
     */
    private function __construct(?Carbon $value = null)
    {
        $this->value = $value;
    }
}
