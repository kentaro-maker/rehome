<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RegionSeeder::class);
        $this->call(PrefectureSeeder::class);
        $this->call(CitySeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
