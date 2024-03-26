<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectInt;

final class HighestDoublesRanking
{
    use ValueObjectInt;

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
