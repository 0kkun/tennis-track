<?php

namespace Database\Factories\Eloquents;

use App\Eloquents\EloquentSportCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Eloquents\EloquentPlayer>
 */
class EloquentPlayerFactory extends Factory
{
    protected $model = EloquentSportCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'name_en' => $faker->unique()->name(),
            'name_jp' => $faker->name(),
            'gender' => rand(0, 1),
            'link' => $faker->url(),
            'birthday' => $faker->date(),
            'country' => $faker->country(),
            'turn_to_pro_year' => $faker->year(),
            'height' => $faker->height(),
            'dominant_arm' => rand(0, 1),
            'backhand_style' => rand(0, 1),
            'sport_category_id' => EloquentSportCategory::first()->id,
        ];
    }
}
