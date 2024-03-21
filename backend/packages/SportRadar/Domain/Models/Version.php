<?php

declare(strict_types=1);

namespace TennisTrack\SportRadar\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class Version
{
    use ValueObjectString;

    /** @var string */
    private const V1 = 'v1';

    /** @var string */
    private const V2 = 'v2';

    /** @var string */
    private const V3 = 'v3';

    private const VALUES = [
        self::V1,
        self::V2,
        self::V3,
    ];

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        if (! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid version');
        }

        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function v1(): self
    {
        return self::from(self::V1);
    }

    /**
     * @return self
     */
    public static function v2(): self
    {
        return self::from(self::V2);
    }

    /**
     * @return self
     */
    public static function v3(): self
    {
        return self::from(self::V3);
    }
}
