<?php

namespace App\Repositories;

use App\Models\TennisAtpRanking;
use App\Repositories\Interfaces\TennisAtpRankingRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentTennisAtpRankingRepository implements TennisAtpRankingRepositoryInterface
{
    /**
     * @param TennisAtpRanking $tennisAtpRanking
     */
    public function __construct(private TennisAtpRanking $tennisAtpRanking)
    {
        $this->tennisAtpRanking = $tennisAtpRanking;
    }

    /**
     * {@inheritDoc}
     */
    public function getLatestUpdatedRecord(): ?TennisAtpRanking
    {
        return $this->tennisAtpRanking
            ->latest('updated_ymd')
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function insert(array $params): void
    {
        $this->tennisAtpRanking
            ->insert($params);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchWithPlayerByParams(?array $searchParams = []): ?Collection
    {
        return $this->tennisAtpRanking
            ->with('player')
            ->when(! empty($searchParams) && ! empty($searchParams['name']), function ($query) use ($searchParams) {
                $query->where('name_en', 'like', $searchParams['name'].'%');
            })
            ->limit(TennisAtpRanking::ITEM_PER_PAGE)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): TennisAtpRanking
    {
        return $this->tennisAtpRanking
            ->with('player')
            ->find($id);
    }
}
