<?php

namespace Database\Seeders;

use App\Models\FavoritePlayer;
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
        FavoritePlayer::factory()->count(10)->create();
    }
}
