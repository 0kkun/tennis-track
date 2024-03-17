<?php

namespace Database\Seeders;

use App\Eloquents\EloquentFavoritePlayer;
use App\Eloquents\EloquentPlayer;
use Illuminate\Database\Seeder;

class FavoritePlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playerIds = EloquentPlayer::where('sport_category_id', 1)->limit(10)->pluck('id');
        foreach ($playerIds as $playerId) {
            EloquentFavoritePlayer::factory(['user_id' => 2, 'player_id' => $playerId])->create();
        }
    }
}
