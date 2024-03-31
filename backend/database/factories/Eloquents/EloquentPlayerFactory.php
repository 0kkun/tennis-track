<?php

namespace Database\Factories\Eloquents;

use App\Eloquents\EloquentSportCategory;
use App\Eloquents\EloquentTennisPlayer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Eloquents\EloquentPlayer>
 */
class EloquentPlayerFactory extends Factory
{
    protected $model = EloquentTennisPlayer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'id' => $faker->unique()->uuid(),
            'name_en' => $faker->unique()->name(),
            'name_ja' => $faker->name(),
            'gender' => rand(0, 1),
            'birthday' => $faker->date(),
            'country' => $faker->country(),
            'country_code' => $faker->country(),
            'pro_year' => $faker->year(),
            'height' => $faker->height(),
            'weight' => $faker->weight(),
            'handedness' => rand(0, 1),
            'highest_singles_ranking' => rand(1, 100),
            'highest_doubles_ranking' => rand(1, 100),
            'abbreviation' => $faker->name(),
            'sport_category_id' => EloquentSportCategory::first()->id,
        ];
    }
}
