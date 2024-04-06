<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase\Ports;

interface PlayerQueryPort
{
    /**
     * @param int $sportCategoryId
     * @return array
     */
    public function fetchBySportCategoryId(int $sportCategoryId): array;
}
