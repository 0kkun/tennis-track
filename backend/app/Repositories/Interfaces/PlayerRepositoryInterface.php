<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface PlayerRepositoryInterface
{
    /**
     * 検索パラメータを用いて選手を取得する
     *
     * @param array $searchParams
     * @return Collection|null
     */
    public function fetchByParams(array $searchParams): ?Collection;
}