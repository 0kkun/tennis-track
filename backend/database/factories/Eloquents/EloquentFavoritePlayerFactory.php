<?php

namespace Database\Factories\Eloquents;

use App\Eloquents\EloquentFavoriteTennisPlayer;
use App\Eloquents\EloquentUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Eloquents\EloquentPlayer>
 */
class EloquentFavoritePlayerFactory extends Factory
{
    protected $model = EloquentFavoriteTennisPlayer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $playerIds = EloquentFavoriteTennisPlayer::where('sport_category_id', 1)->limit(1000)->pluck('id');

        return [
            'user_id' => EloquentUser::first()->id,
            'player_id' => $this->faker->randomElement($playerIds),
        ];
    }
}
