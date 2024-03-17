<?php
declare(strict_types=1);

namespace TennisTrack\Common\ValueObject;

trait ValueObjectFrom
{
    /**
     * @param mixed $value
     * @return self
     */
    public static function from($value): self
    {
        if ($value instanceof static) {
            return $value;
        }

        return new self($value);
    }

    /**
     * @param mixed $value
     * @return \InvalidArgumentException
     */
    private static function createInvalidArgumentException($value): \InvalidArgumentException
    {
        return new \InvalidArgumentException(
            sprintf(
                'The value "%s" is not valid for this object',
                is_scalar($value) ? $value : gettype($value)
            )
        );
    }
}
