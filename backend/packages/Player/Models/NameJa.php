<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;

final class NameJa
{
    use ValueObjectString;

    /**
     * @param string|null $value
     */
    public function __construct(private ?string $value)
    {
        $this->value = $value;
    }
}
