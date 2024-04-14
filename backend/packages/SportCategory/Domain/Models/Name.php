<?php

declare(strict_types=1);

namespace TennisTrack\SportCategory\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class Name
{
    use ValueObjectString;

    /** @var string */
    private const TENNIS = 'Tennis';

    /** @var string */
    private const SOCCER = 'Soccer';

    /** @var string */
    private const BASEBALL = 'BaseBall';

    /** @var array */
    private const CATEGORY_NAMES = [
        self::TENNIS,
        self::SOCCER,
        self::BASEBALL,
    ];

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        if (! in_array($value, self::CATEGORY_NAMES, true)) {
            throw new InvalidArgumentException('Invalid category name');
        }
        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function asTennis(): self
    {
        return new self(self::TENNIS);
    }

    /**
     * @return self
     */
    public static function asSoccer(): self
    {
        return new self(self::SOCCER);
    }

    /**
     * @return self
     */
    public static function asBaseBall(): self
    {
        return new self(self::BASEBALL);
    }

    /**
     * @return bool
     */
    public function isTennis(): bool
    {
        return $this->value === self::TENNIS;
    }

    /**
     * @return bool
     */
    public function isSoccer(): bool
    {
        return $this->value === self::SOCCER;
    }

    /**
     * @return bool
     */
    public function isBaseBall(): bool
    {
        return $this->value === self::BASEBALL;
    }

    /**
     * @return array
     */
    public static function getNames(): array
    {
        return self::CATEGORY_NAMES;
    }
}
