<?php

declare(strict_types=1);

namespace TennisTrack\Common\ValueObject;

trait ValueObjectFloatNull
{
    use ValueObjectFrom;

    /**
     * @param float|null $value
     */
    private function __construct(private ?float $value = 0.0)
    {
        $this->value = $value;
    }

    /**
     * @return float|null
     */
    public function toFloat(): ?float
    {
        if (is_null($this->value)) {
            return null;
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isZero(): bool
    {
        return $this->value === 0;
    }

    /**
     * @param self $valueObject
     * @return bool
     */
    public function equals(self $valueObject): bool
    {
        return $this->value === $valueObject->toFloat();
    }

    /**
     * @param $value
     * @return self
     */
    public static function from($value = null): self
    {
        if (is_null($value)) {
            return new self();
        }
        if ($value instanceof self) {
            return $value;
        }
        if (is_float($value)) {
            return new self($value);
        }
        throw self::createInvalidArgumentException($value);
    }
}
