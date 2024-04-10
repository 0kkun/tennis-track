<?php

declare(strict_types=1);

namespace TennisTrack\SportCategory\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;
use TennisTrack\Common\Exceptions\InvalidArgumentException;

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
        if (!in_array($value, self::CATEGORY_NAMES, true)) {
            throw new InvalidArgumentException('Invalid category name');
        }
        $this->value = $value;
    }

    /**
     * @return boolean
     */
    public function asTennis(): self
    {
        return new self(self::TENNIS);
    }

    /**
     * @return boolean
     */
    public function asSoccer(): self
    {
        return new self(self::SOCCER);
    }

    /**
     * @return boolean
     */
    public function asBaseBall(): self
    {
        return new self(self::BASEBALL);
    }

    /**
     * @return boolean
     */
    public function isTennis(): bool
    {
        return $this->value === self::TENNIS;
    }

    /**
     * @return boolean
     */
    public function isSoccer(): bool
    {
        return $this->value === self::SOCCER;
    }

    /**
     * @return boolean
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
