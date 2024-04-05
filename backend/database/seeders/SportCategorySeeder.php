<?php

namespace Database\Seeders;

use App\Eloquents\EloquentSportCategory;
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
        EloquentSportCategory::factory()->create(['name' => 'Tennis']);
        EloquentSportCategory::factory()->create(['name' => 'Soccer']);
        EloquentSportCategory::factory()->create(['name' => 'Baseball']);
    }
}
