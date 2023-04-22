<?php

namespace App\Repositories;

use App\Models\Player;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentPlayerRepository implements PlayerRepositoryInterface
{
    /**
     * @param Player $player
     */
    public function __construct(private Player $player)
    {
        $this->player = $player;
    }

    /**
     * @inheritDoc
     */
    public function fetchByParams(array $searchParams): ?Collection
    {
        return $this->player
            ->when(!empty($searchParams['sport_category_id']), function ($query) use ($searchParams) {
                $query->where('sport_category_id', $searchParams['sport_category_id']);
            })
            ->when(!empty($searchParams['name']), function ($query) use ($searchParams) {
                $query->orWhere('name_jp', 'like', $searchParams['name'] . '%')
                    ->orWhere('name_en', 'like', $searchParams['name'] . '%');
            })
            ->when(!empty($searchParams['country']), function ($query) use ($searchParams) {
                $query->where('country', 'like', $searchParams['country'] . '%');
            })
            ->when(!empty($searchParams['dominant_arm']), function ($query) use ($searchParams) {
                $query->where('dominant_arm', $searchParams['dominant_arm']);
            })
            ->when(!empty($searchParams['backhand_style']), function ($query) use ($searchParams) {
                $query->where('backhand_style', $searchParams['backhand_style']);
            })
            ->limit(Player::ITEM_PER_PAGE)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function destroy(int $id): void
    {
        $this->player->find($id)->delete();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): Player
    {
        return $this->player->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $player): void
    {
        $this->player->create($player);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $player): void
    {
        $this->player
            ->find($id)
            ->update($player);
    }
}