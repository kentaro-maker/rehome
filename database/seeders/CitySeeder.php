<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'name' => '札幌市',
            'prefecture' => '北海道',
            'region' => '北海道',
            'population' => '1952356',
            'investigated_at' => date(2015),
        ]);

        City::create([
            'name' => '函館市',
            'prefecture' => '北海道',
            'region' => '北海道',
            'population' => '265979',
            'investigated_at' => '2015',
        ]);

        City::create([
            'name' => '小樽市',
            'prefecture' => '北海道',
            'region' => '北海道',
            'population' => '121924',
            'investigated_at' => '2015',
        ]);
    }
}
