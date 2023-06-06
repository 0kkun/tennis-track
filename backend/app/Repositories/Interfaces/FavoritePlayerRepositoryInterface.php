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

    /**
     * favoriteを1件生成する
     *
     * @param integer $userId
     * @param integer $playerId
     * @return void
     */
    public function create(int $userId, int $playerId): void;

    /**
     * お気に入り選手を1件削除
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id): void;
}
