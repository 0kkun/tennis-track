<?php

namespace App\Repositories\Interfaces;

use App\Models\TennisAtpRanking;
use Illuminate\Support\Collection;

interface TennisAtpRankingRepositoryInterface
{
    /**
     * ランキングの最終更新日が最も直近のものを1件取得する
     * 
     * @return TennisAtpRanking|null
     */
    public function getLatestUpdatedRecord(): ?TennisAtpRanking;

    /**
     * テニスのATPランキングのinsertを行う。
     *
     * @param array $params
     * @return void
     */
    public function insert(array $params): void;
}