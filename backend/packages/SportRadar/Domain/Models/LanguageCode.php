<?php

declare(strict_types=1);

namespace TennisTrack\SportRadar\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class LanguageCode
{
    use ValueObjectString;

    /** @var string */
    private const EN = 'en';

    /** @var string */
    private const JA = 'ja';

    private const VALUES = [
        self::EN,
        self::JA,
    ];

    /**
     * @param string $value
     */
    private function __construct(private string $value = 'en')
    {
        if (! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid language code');
        }

        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function en(): self
    {
        return self::from(self::EN);
    }

    /**
     * @return self
     */
    public static function ja(): self
    {
        return self::from(self::JA);
    }
}
