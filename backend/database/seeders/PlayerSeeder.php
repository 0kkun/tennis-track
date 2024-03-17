<?php

namespace Database\Seeders;

use App\Eloquents\EloquentPlayer;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EloquentPlayer::factory()->count(10)->create();
    }
}
