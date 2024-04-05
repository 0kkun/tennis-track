<?php

declare(strict_types=1);

namespace TennisTrack\Player\UseCase\Ports;

use TennisTrack\Player\Domain\Models\Id;
use TennisTrack\Player\Domain\Models\TennisPlayers;

interface PlayerAdapterCommandPort
{
    // /**
    //  * @param Player $player
    //  * @return void
    //  */
    // public function create(Player $player): void;

    // /**
    //  * @param Id $id
    //  * @param Player $player
    //  * @return void
    //  */
    // public function updateById(Id $id, Player $player): void;

    // /**
    //  * @param Id $id
    //  * @return void
    //  */
    // public function deleteById(Id $id): void;

    // /**
    //  * @param Id $id
    //  * @return Player
    //  */
    // public function getByIdWithSportCategory(Id $id): Player;

    /**
     * @param int $sportCategoryId
     * @return array
     */
    public function fetchBySportCategoryId(int $sportCategoryId): array;

    /**
     * upsertを行う.
     * idが同じのものはupdate、それ以外はinsert
     * @param TennisPlayers $players
     * @param array $keys
     * @return void
     */
    public function upsertByKeys(TennisPlayers $players, array $keys): void;
}
