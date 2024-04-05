<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectIntNull;

final class ProYear
{
    use ValueObjectIntNull;

    /**
     * @param int|null $value
     */
    private function __construct(?int $value = null)
    {
        $this->value = $value;
    }
}
