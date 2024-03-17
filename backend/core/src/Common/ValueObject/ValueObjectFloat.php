<?php

declare(strict_types=1);

namespace TennisTrack\Common\ValueObject;

trait ValueObjectFloat
{
    use ValueObjectFrom;

    /** @var float */
    private $value;

    /**
     * @param float $value
     */
    private function __construct(float $value = 0.0)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        return $this->value;
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
