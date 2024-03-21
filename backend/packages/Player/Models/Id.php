<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;

final class Id
{
    use ValueObjectString;

    /**
     * CompetitorId
     * @param string $value
     */
    public function __construct(private string $value)
    {
        $this->value = $value;
    }
}
