<?php

declare(strict_types=1);

namespace TennisTrack\User\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;

final class Email
{
    use ValueObjectString;

    /**
     * @param string $value
     */
    private function __construct(string $value = '')
    {
        $this->value = $value;
    }
}
