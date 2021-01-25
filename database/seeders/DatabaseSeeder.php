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
        //$this->call(CitySeeder::class);
        //$this->call(EventSeeder::class);
        $this->call(ApplySeeder::class);
    }
}
