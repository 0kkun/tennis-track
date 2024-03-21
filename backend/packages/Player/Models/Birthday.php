<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectDatetime;

final class Birthday
{
    use ValueObjectDatetime;

    /**
     * @param \DateTimeImmutable|null $value
     */
    public function __construct(private ?\DateTimeImmutable $value)
    {
        $this->value = $value;
    }
}
