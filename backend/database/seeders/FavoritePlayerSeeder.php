<?php

namespace Database\Seeders;

use App\Models\FavoritePlayer;
use Illuminate\Database\Seeder;
use App\Models\Player;

class FavoritePlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playerIds = Player::where('sport_category_id', 1)->limit(10)->pluck('id');
        foreach ( $playerIds as $playerId) {
            FavoritePlayer::factory(['user_id' => 2, 'player_id' =>  $playerId])->create();
        }
    }
}
