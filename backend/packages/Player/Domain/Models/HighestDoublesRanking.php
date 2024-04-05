<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectIntNull;

final class HighestDoublesRanking
{
    use ValueObjectIntNull;

    /**
     * @param int|null $value
     */
    private function __construct(?int $value = null)
    {
        if (! is_null($value) && ($value < 0 || $value > 1000)) {
            throw new InvalidArgumentException('Invalid highest doubles ranking');
        }
        $this->value = $value;
    }
}
