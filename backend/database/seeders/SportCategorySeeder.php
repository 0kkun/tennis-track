<?php

namespace Database\Seeders;

use App\Eloquents\EloquentSportCategory;
use Illuminate\Database\Seeder;
use TennisTrack\SportCategory\Domain\Models\SportCategory;

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
