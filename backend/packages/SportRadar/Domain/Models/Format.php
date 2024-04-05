<?php

declare(strict_types=1);

namespace TennisTrack\SportRadar\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class Format
{
    use ValueObjectString;

    /** @var string */
    private const JSON = 'json';

    /** @var string */
    private const XML = 'xml';

    private const VALUES = [
        self::JSON,
        self::XML,
    ];

    /**
     * @param [type] $value
     */
    private function __construct(private string $value = self::JSON)
    {
        if (! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid format');
        }

        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function json(): self
    {
        return self::from(self::JSON);
    }

    /**
     * @return self
     */
    public static function xml(): self
    {
        return self::from(self::XML);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
