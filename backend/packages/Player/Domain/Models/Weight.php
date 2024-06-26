<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectIntNull;

final class Weight
{
    use ValueObjectIntNull;

    /**
     * @param int|null $value
     */
    private function __construct(?int $value = null)
    {
        if (! is_null($value) && ($value < 0 || $value > 200)) {
            throw new InvalidArgumentException('Invalid weight');
        }
        $this->value = $value;
    }
}
