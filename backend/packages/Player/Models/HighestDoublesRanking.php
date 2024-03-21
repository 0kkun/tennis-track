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
    public function __construct(private ?int $value)
    {
        if ($value !== null && ($value < 0 || $value > 1000)) {
            throw new InvalidArgumentException('Invalid highest doubles ranking');
        }
        $this->value = $value;
    }
}
