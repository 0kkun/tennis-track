<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;

final class NameEn
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
