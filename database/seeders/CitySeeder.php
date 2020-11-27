<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use Storage;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('city.json');
        $japan = json_decode($json, true);

        foreach($japan as $region) {
            foreach($region['prefs'] as $pref) {
                foreach($pref['cities'] as $city){

                    City::create([
                        'name' => $city['name'],
                        'slug' => $city['slug'],
                        'prefecture' => $pref['slug'],
                        'region' => $region['slug'],
                    ]);

                }
            }
        }
    }
}
