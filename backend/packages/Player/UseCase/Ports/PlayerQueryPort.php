<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase\Ports;

use TennisTrack\SportCategory\Domain\Models\Id;

interface PlayerQueryPort
{
    /**
     * @param Id $sportCategoryId
     * @return array
     */
    public function fetchBySportCategoryId(Id $sportCategoryId): array;
}
