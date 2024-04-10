<?php

declare(strict_types=1);

namespace TennisTrack\SportCategory\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;

final class Name
{
    use ValueObjectString;

    private const TENNIS = 'Tennis';

    private const CATEGORY_NAMES = [
        self::TENNIS,
    ];

    /**
     * @param string|null $value
     */
    private function __construct(?string $value = null)
    {
        if (!in_array($value, self::CATEGORY_NAMES, true)) {
            throw new \InvalidArgumentException('Invalid category name');
        }
        $this->value = $value;
    }
}
