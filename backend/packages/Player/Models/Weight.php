<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectInt;

final class Weight
{
    use ValueObjectInt;

    /**
     * @param int|null $value
     */
    public function __construct(private ?int $value)
    {
        if ($value !== null && ($value < 0 || $value > 200)) {
            throw new InvalidArgumentException('Invalid weight');
        }
        $this->value = $value;
    }
}
