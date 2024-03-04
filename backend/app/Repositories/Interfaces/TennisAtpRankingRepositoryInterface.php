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

    /**
     * パラメータに基づくATPランキング一覧をplayerと共に取得する
     *
     * @param array|null $params
     * @return Collection|null
     */
    public function fetchWithPlayerByParams(?array $params = []): ?Collection;

    /**
     * idでランキングを1件取得する
     *
     * @param int $id
     * @return TennisAtpRanking
     */
    public function getById(int $id): TennisAtpRanking;
}
