<?php

declare(strict_types=1);

namespace TennisTrack\SportRadar\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;

final class Path
{
    use ValueObjectString;

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        $this->value = $value;
    }
}
