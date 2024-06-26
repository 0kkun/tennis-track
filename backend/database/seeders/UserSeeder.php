<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::today();

        DB::table('users')->insert([
            [
                'name' => 'user',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
