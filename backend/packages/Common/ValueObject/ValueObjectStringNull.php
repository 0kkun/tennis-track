<?php

declare(strict_types=1);

namespace TennisTrack\Common\ValueObject;

trait ValueObjectStringNull
{
    use ValueObjectFrom;

    /**
     * @param string|null $value
     */
    private function __construct(private ?string $value = null)
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function toString(): ?string
    {
        if (is_null($this->value)) {
            return null;
        }
        return $this->value;
    }

    /**
     * @param self $valueObject
     * @return bool
     */
    public function equals(self $valueObject): bool
    {
        return $this->value === $valueObject->toString();
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
        if (is_string($value)) {
            return new self($value);
        }
        throw self::createInvalidArgumentException($value);
    }
}
