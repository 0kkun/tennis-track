<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Common\ValueObject\ValueObjectString;

final class Handedness
{
    use ValueObjectString;

    private const RIGHT = 'right';

    private const LEFT = 'left';

    private const VALUES = [
        self::RIGHT,
        self::LEFT,
    ];

    /**
     * @param string|null $value
     */
    public function __construct(private ?string $value)
    {
        if (! is_null($value) && ! in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException('Invalid Handedness Value');
        }
        $this->value = $value;
    }
}
