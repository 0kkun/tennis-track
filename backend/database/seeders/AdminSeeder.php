<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::today();

        DB::table('admins')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
