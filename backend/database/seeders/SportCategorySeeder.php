<?php

namespace Database\Seeders;

use App\Models\SportCategory;
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
        SportCategory::factory()->create(['name'  => 'テニス']);
        SportCategory::factory()->create(['name'  => 'サッカー']);
        SportCategory::factory()->create(['name'  => '野球']);
    }
}