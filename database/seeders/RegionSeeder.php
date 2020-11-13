<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $regions = [
        ['北海道',  'hokkaido'],
        ['東北',    'tohoku'],
        ['関東',    'kanto'],
        ['甲信越',  'koshinetsu'],
        ['北陸',    'hokuriku'],
        ['東海',    'tokai'],
        ['関西',    'kansai'],
        ['中国',    'chugoku'],
        ['四国',    'shikoku'],
        ['九州・沖縄',  'kyushu-okinawa'],
       ];
       
       foreach ($regions as $region) {
            Region::create([
                'name' => $region[0],
                'slug' => $region[1],
            ]);
       }
    }
}
