<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectFloatNull;

final class Height
{
    use ValueObjectFloatNull;

    /**
     * @param float|null $value
     */
    private function __construct(?float $value = null)
    {
        if (! is_null($value) && ($value < 0.0 || $value > 300.0)) {
            throw new InvalidArgumentException('Invalid hight');
        }
        $this->value = $value;
    }
}
