<?php

declare(strict_types=1);

namespace TennisTrack\FavoritePlayer\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectInt;

final class Id
{
    use ValueObjectInt;

    /**
     * @param string $value
     */
    private function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return empty($this->value);
    }
}
