<?php

namespace Database\Factories;

use App\Models\SportCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name_en' => fake()->name(),
            'name_jp' => fake()->name(),
            'gender' => rand(0, 1),
            'birthday' => fake()->date(),
            'country' => fake()->country(),
            'dominant_arm' => rand(0, 2),
            'backhand_style' => rand(0, 1),
            'sport_category_id' => SportCategory::first()->id,
        ];
    }
}
