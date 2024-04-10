<?php

namespace Database\Seeders;

use App\Eloquents\EloquentSportCategory;
use TennisTrack\SportCategory\Domain\Models\SportCategory;
use Illuminate\Database\Seeder;

class SportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (SportCategory::getNames() as $name) {
            EloquentSportCategory::factory()->create(['name' => $name]);
        }
    }
}
