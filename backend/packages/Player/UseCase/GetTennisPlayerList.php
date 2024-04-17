<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase;

use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\Ports\PlayerQueryPort;
use TennisTrack\SportCategory\Domain\Models\Name as SportCategoryName;
use TennisTrack\SportCategory\UseCase\Ports\SportCategoryQueryPort;

class GetTennisPlayerList
{
    /**
     * @param PlayerQueryPort $playerQuery
     * @param SportCategoryQueryPort $sportCategoryQuery
     */
    public function __construct(
        private PlayerQueryPort $playerQuery,
        private SportCategoryQueryPort $sportCategoryQuery
    ) {
        $this->playerQuery = $playerQuery;
        $this->sportCategoryQuery = $sportCategoryQuery;
    }

    /**
     * @param integer|null $limit
     * @return array
     */
    public function execute(int $limit = null): array
    {
        $sportCategory = $this->sportCategoryQuery->getByName(SportCategoryName::asTennis()->toString());
        $players = $this->playerQuery->fetchBySportCategoryId($sportCategory->id(), $limit);

        return $players;
    }
}
