<?php

declare(strict_types=1);

namespace TennisTrack\Common\ValueObject;

trait ValueObjectBool
{
    use ValueObjectFrom;

    /**
     * @param bool $value
     */
    private function __construct(private bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function asFalse(): self
    {
        return new self(false);
    }

    /**
     * @return self
     */
    public static function asTrue(): self
    {
        return new self(true);
    }

    /**
     * @return bool
     */
    public function toBool(): bool
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return (int) $this->value;
    }

    /**
     * @param $value
     * @return self
     */
    public static function from($value): self
    {
        if (is_null($value)) {
            return new self(false);
        } elseif (is_int($value)) {
            return new self($value !== 0);
        } elseif (is_float($value)) {
            return new self($value !== 0.0);
        } elseif (is_bool($value)) {
            return new self($value);
        } elseif ($value instanceof self) {
            return $value;
        } else {
            throw self::createInvalidArgumentException($value);
        }
    }
}
