<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class Gender
{
    use ValueObjectString;

    private const MALE = 'male';

    private const FEMALE = 'female';

    private const VALUES = [
        self::MALE,
        self::FEMALE,
    ];

    /**
     * @param string|null $value
     */
    public function __construct(?string $value)
    {
        if (! is_null($value) && ! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid Gender Value');
        }
        $this->value = $value;
    }
}
