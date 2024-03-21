<?php

declare(strict_types=1);

namespace TennisTrack\SportRadar\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class Category
{
    use ValueObjectString;

    /** @var string */
    private const PLAYERS = 'players';

    /** @var string */
    private const TOURNAMENTS = 'tournaments';

    private const VALUES = [
        self::PLAYERS,
        self::TOURNAMENTS,
    ];

    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        if (! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid category');
        }

        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function players(): self
    {
        return self::from(self::PLAYERS);
    }

    /**
     * @return self
     */
    public static function tournaments(): self
    {
        return self::from(self::TOURNAMENTS);
    }
}
