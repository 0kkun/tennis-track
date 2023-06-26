<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class FavoritePlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $playerIds = Player::where('sport_category_id', 1)->limit(1000)->pluck('id');

        return [
            'user_id' => User::first()->id,
            'player_id' => $this->faker->randomElement($playerIds),
        ];
    }
}
