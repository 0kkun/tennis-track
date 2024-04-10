<?php

declare(strict_types=1);

namespace TennisTrack\SportCategory\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectInt;

final class Id
{
    use ValueObjectInt;

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return empty($this->value);
    }
}
