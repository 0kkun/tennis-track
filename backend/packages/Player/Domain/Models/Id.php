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
    private function __construct(string $value = '')
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return empty($this->value);
    }
}
