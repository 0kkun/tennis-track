<?php

namespace Database\Factories\Eloquents;

use App\Eloquents\EloquentPlayer;
use App\Eloquents\EloquentTennisRanking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Eloquents\EloquentTennisRanking>
 */
class EloquentTennisRankingFactory extends Factory
{
    protected $model = EloquentTennisRanking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'rank' => $faker->numberBetween(1, 100),
            'point' => $faker->numberBetween(1, 10000),
            'ranking_date' => $faker->date(),
            'player_id' => EloquentPlayer::first()->id,
            'movement' => $faker->numberBetween(-100, 100),
            'type' => 'atp_singles',
            'played_count' => $faker->numberBetween(1, 100),
            'ranking_date' => $faker->date(),
        ];
    }
}
