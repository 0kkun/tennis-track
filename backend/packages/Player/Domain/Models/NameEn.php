<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectStringNull;

final class NameEn
{
    use ValueObjectStringNull;

    /**
     * @param string|null $value
     */
    private function __construct(?string $value = null)
    {
        $this->value = $value;
    }
}
