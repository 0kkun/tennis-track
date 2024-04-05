<?php

declare(strict_types=1);

namespace TennisTrack\Common\ValueObject;

trait ValueObjectInt
{
    use ValueObjectFrom;

    /**
     * @param int $value
     */
    private function __construct(private int $value = 0)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
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
        return $this->value === $valueObject->toInt();
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
        if (is_int($value)) {
            return new self($value);
        }
        throw self::createInvalidArgumentException($value);
    }
}
