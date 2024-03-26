<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use Carbon\Carbon;
use TennisTrack\Common\Exceptions\RuntimeException;
use TennisTrack\Common\ValueObject\ValueObjectDatetime;

final class Birthday
{
    use ValueObjectDatetime;

    /**
     * @param \Carbon|null $value
     */
    private function __construct(?Carbon $value = null)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function age(Carbon $now): int
    {
        if ($this->value === null) {
            throw new RuntimeException('Birthday is not set.');
        }
        return $now->diffInYears($this->value);
    }
}
