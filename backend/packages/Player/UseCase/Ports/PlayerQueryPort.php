<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase\Ports;

use TennisTrack\SportCategory\Domain\Models\Id as SportCategoryId;
use TennisTrack\Player\Domain\Models\Id;
use TennisTrack\Player\Domain\Models\TennisPlayer;

interface PlayerQueryPort
{
    /**
     * @param SportCategoryId $sportCategoryId
     * @return array
     */
    public function fetchBySportCategoryId(SportCategoryId $sportCategoryId): array;

    /**
     * @param Id $id
     * @return TennisPlayer
     */
    public function getById(Id $id): TennisPlayer;
}
