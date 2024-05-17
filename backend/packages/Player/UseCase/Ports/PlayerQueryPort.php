<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase\Ports;

use TennisTrack\Player\Domain\Models\Id;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\SportCategory\Domain\Models\Id as SportCategoryId;

interface PlayerQueryPort
{
    /**
     * @param SportCategoryId $sportCategoryId
     * @return array
     */

    /**
     * @param SportCategoryId $sportCategoryId
     * @param int|null $limit
     * @return array
     */
    public function fetchBySportCategoryId(SportCategoryId $sportCategoryId, int $limit = null): array;

    /**
     * @param Id $id
     * @return TennisPlayer
     */
    public function getById(Id $id): TennisPlayer;
}
