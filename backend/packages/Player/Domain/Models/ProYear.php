<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectInt;

final class ProYear
{
    use ValueObjectInt;

    /**
     * @param int|null $value
     */
    private function __construct(?int $value = null)
    {
        $this->value = $value;
    }
}
