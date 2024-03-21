<?php

declare(strict_types=1);

namespace TennisTrack\SportRadar\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class AccessLevel
{
    use ValueObjectString;

    /** @var string */
    private const TRIAL = 'trial';

    /** @var string */
    private const PRODUCTION = 'production';

    private const VALUES = [
        self::TRIAL,
        self::PRODUCTION,
    ];

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid access level');
        }

        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function trial(): self
    {
        return self::from(self::TRIAL);
    }

    /**
     * @return self
     */
    public static function production(): self
    {
        return self::from(self::PRODUCTION);
    }
}
