<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectInt;

final class Height
{
    use ValueObjectInt;

    /**
     * @param int|null $value
     */
    private function __construct(?int $value = null)
    {
        if (! is_null($value) && ($value < 0 || $value > 300)) {
            throw new InvalidArgumentException('Invalid hight');
        }
        $this->value = $value;
    }
}