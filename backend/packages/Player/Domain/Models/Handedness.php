<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectStringNull;

final class Handedness
{
    use ValueObjectStringNull;

    /**
     * @var string
     */
    private const RIGHT = 'right';

    /**
     * @var string
     */
    private const LEFT = 'left';

    /**
     * @var string[]
     */
    private const VALUES = [
        self::RIGHT,
        self::LEFT,
    ];

    /**
     * @param string|null $value
     */
    private function __construct(?string $value = null)
    {
        if (! is_null($value) && ! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid Handedness Value');
        }
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isRight(): bool
    {
        return $this->value === self::RIGHT;
    }

    /**
     * @return bool
     */
    public function isLeft(): bool
    {
        return $this->value === self::LEFT;
    }

    /**
     * @return int|null
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
