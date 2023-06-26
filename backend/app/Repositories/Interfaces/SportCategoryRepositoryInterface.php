<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface SportCategoryRepositoryInterface
{
    /**
     * スポーツカテゴリを全て取得する
     *
     * @return Collection|null
     */
    public function fetchAll(): ?Collection;

    /**
     * 名前を指定してスポーツカテゴリを1件取得する
     *
     * @param string $name
     * @return int|null
     */
    public function getIdByName(string $name): ?int;
}
