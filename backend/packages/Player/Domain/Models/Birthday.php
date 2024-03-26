<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use Carbon\Carbon;
use TennisTrack\Common\ValueObject\ValueObjectDatetime;

final class Birthday
{
    use ValueObjectDatetime;

    /**
     * @param \Carbon|null $value
     */
    public function __construct(?Carbon $value)
    {
        $this->value = $value;
    }
}
