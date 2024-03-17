<?php

namespace Database\Factories\Eloquents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Eloquents\EloquentSportCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Eloquents\EloquentPlayer>
 */
class EloquentSportCategoryFactory extends Factory
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
            'name' => $faker->name(),
        ];
    }
}
