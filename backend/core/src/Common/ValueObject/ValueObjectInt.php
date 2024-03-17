<?php

namespace core\Common\ValueObject;

trait ValueObjectInt
{
    use ValueObjectFrom;

    private int $value;

    /**
     * @param integer $value
     */
    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    /**
     * @return integer
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @return integer
     */
    public function toInt(): int
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function isZero(): bool
    {
        return $this->value === 0;
    }

    /**
     * @param self $valueObject
     * @return boolean
     */
    public function equals(self $valueObject): bool
    {
        return $this->value === $valueObject->value();
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
