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
     * @inheritDoc
     */
    public function getLatestUpdatedRecord(): ?TennisAtpRanking
    {
        return $this->tennisAtpRanking
            ->latest('updated_ymd')
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function insert(array $params): void
    {
        $this->tennisAtpRanking
            ->insert($params);
    }
}