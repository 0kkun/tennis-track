<?php

declare(strict_types=1);

namespace TennisTrack\SportRadar\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class ApiName
{
    use ValueObjectString;

    /** @var string[] */
    private const VALUES = [
        'player_profile',
        'player_rankings',
        'player_race_rankings',
        'player_head_to_head',
    ];

    /**
     * @param string $value
     */
    private function __construct(private string $value)
    {
        if (! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid api name');
        }

        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function playerProfile(): self
    {
        return self::from('player_profile');
    }

    /**
     * @return self
     */
    public static function playerRankings(): self
    {
        return self::from('player_rankings');
    }

    /**
     * @return self
     */
    public static function playerRaceRankings(): self
    {
        return self::from('player_race_rankings');
    }

    /**
     * @return self
     */
    public static function playerHeadToHead(): self
    {
        return self::from('player_head_to_head');
    }
}
