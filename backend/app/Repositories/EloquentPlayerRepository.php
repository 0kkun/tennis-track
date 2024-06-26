<?php

namespace App\Repositories;

use App\Eloquents\EloquentPlayer;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentPlayerRepository implements PlayerRepositoryInterface
{
    /**
     * @param EloquentPlayer $player
     */
    public function __construct(private EloquentPlayer $player)
    {
        $this->player = $player;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchByParams(array $searchParams): ?Collection
    {
        return $this->player
            ->with('sportCategory')
            ->when(! empty($searchParams['sport_category_id']), function ($query) use ($searchParams) {
                $query->where('sport_category_id', $searchParams['sport_category_id']);
            })
            ->when(! empty($searchParams['name']), function ($query) use ($searchParams) {
                $query->where('name_en', 'like', '%'.$searchParams['name'].'%');
                // FIXME: OR検索がうまくいかない。
                // $query->orWhere('name_jp', 'like', '%' . $searchParams['name'] . '%')
                //     ->orWhere('name_en', 'like', '%' . $searchParams['name'] . '%');
            })
            ->when(! empty($searchParams['country']), function ($query) use ($searchParams) {
                $query->where('country', 'like', $searchParams['country'].'%');
            })
            ->when(! empty($searchParams['dominant_arm']), function ($query) use ($searchParams) {
                $query->where('dominant_arm', $searchParams['dominant_arm']);
            })
            ->when(! empty($searchParams['backhand_style']), function ($query) use ($searchParams) {
                $query->where('backhand_style', $searchParams['backhand_style']);
            })
            ->limit(EloquentPlayer::ITEM_PER_PAGE)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(int $id): void
    {
        $this->player->find($id)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): EloquentPlayer
    {
        return $this->player
            ->with('sportCategory')
            ->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $player): int
    {
        return $this->player->create($player)->id;
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $player): void
    {
        $this->player
            ->find($id)
            ->update($player);
    }

    /**
     * {@inheritDoc}
     */
    public function upsertByNameEn(array $params): void
    {
        $this->player->upsert($params, ['name_en']);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchBySportCategoryId(int $sportCategoryId): ?Collection
    {
        return $this->player
            ->where('sport_category_id', $sportCategoryId)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function fetch(): Collection
    {
        return $this->player->select('name_en', 'country')->get();
    }

    /**
     * {@inheritDoc}
     */
    public function updateMultiple(array $players): void
    {
        $this->player->upsert(
            $players,
            ['id'],
        );
    }
}
