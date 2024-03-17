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
        EloquentSportCategory::factory()->create(['name' => 'テニス']);
        EloquentSportCategory::factory()->create(['name' => 'サッカー']);
        EloquentSportCategory::factory()->create(['name' => '野球']);
    }
}
