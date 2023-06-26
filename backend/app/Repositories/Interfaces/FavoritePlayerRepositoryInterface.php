<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface FavoritePlayerRepositoryInterface
{
    /**
     * userIdにひもづくFavoritePlayerデータを取得する
     * withでplayerデータも取得する
     *
     * @param int $userId
     * @return Collection
     */
    public function fetchWithPlayerByUserId(int $userId): Collection;

    /**
     * favoriteを1件生成する
     *
     * @param int $userId
     * @param int $playerId
     * @return void
     */
    public function create(int $userId, int $playerId): void;

    /**
     * お気に入り選手を1件削除
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void;
}
