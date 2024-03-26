<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;

final class CountryCode
{
    use ValueObjectString;

    /**
     * @param string|null $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value;
    }
}
