<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface FavoritePlayerRepositoryInterface
{
    /**
     * userIdにひもづくFavoritePlayerデータを取得する
     * withでplayerデータも取得する
     *
     * @param integer $userId
     * @return Collection
     */
    public function fetchWithPlayerByUserId(int $userId): Collection;
}
