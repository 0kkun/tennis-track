<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectStringNull;

final class Gender
{
    use ValueObjectStringNull;

    /**
     * @var string
     */
    private const MALE = 'male';

    /**
     * @var string
     */
    private const FEMALE = 'female';

    /**
     * @var string[]
     */
    private const VALUES = [
        self::MALE,
        self::FEMALE,
    ];

    /**
     * @param string|null $value
     */
    private function __construct(?string $value = null)
    {
        if (! is_null($value) && ! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid Gender Value');
        }
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isMale(): bool
    {
        return $this->value === self::MALE;
    }

    /**
     * @return bool
     */
    public function isFemale(): bool
    {
        return $this->value === self::FEMALE;
    }

    /**
     * @return integer|null
     */
    public function toInt(): ?int
    {
        if (is_null($this->value)) {
            return null;
        }
        return array_search($this->value, self::VALUES, true);
    }

    /**
     * @param int $value
     * @return self
     */
    public static function fromInt(int $value): self
    {
        return new self(self::VALUES[$value]);
    }
}
