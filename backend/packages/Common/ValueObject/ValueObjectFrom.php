<?php

declare(strict_types=1);

namespace TennisTrack\Common\ValueObject;

use TennisTrack\Common\Exceptions\InvalidArgumentException;

trait ValueObjectFrom
{
    /**
     * @param mixed $value
     * @return self
     */
    public static function from($value = null): self
    {
        if ($value instanceof static) {
            return $value;
        }

        return new self($value);
    }

    /**
     * @param mixed $value
     * @return InvalidArgumentException
     */
    private static function createInvalidArgumentException($value): InvalidArgumentException
    {
        return new InvalidArgumentException(
            sprintf(
                'The value "%s" is not valid for this object',
                is_scalar($value) ? $value : gettype($value)
            )
        );
    }
}
