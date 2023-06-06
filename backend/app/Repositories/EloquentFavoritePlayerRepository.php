<?php

namespace App\Repositories;

use App\Models\FavoritePlayer;
use App\Repositories\Interfaces\FavoritePlayerRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentFavoritePlayerRepository implements FavoritePlayerRepositoryInterface
{
    /**
     * @param FavoritePlayer $favoritePlayer
     */
    public function __construct(private FavoritePlayer $favoritePlayer)
    {
        $this->favoritePlayer = $favoritePlayer;
    }

    /**
     * @inheritDoc
     */
    public function fetchWithPlayerByUserId(int $userId): Collection
    {
        return $this->favoritePlayer
            ->with('player')
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, int $playerId): void
    {
        $this->favoritePlayer
            ->create([
                'user_id' => $userId,
                'player_id' => $playerId,
            ]);
    }

    /**
     * @inheritDoc
     */
    public function destroy(int $id): void
    {
        $this->favoritePlayer
            ->find($id)
            ->delete();
    }
}
