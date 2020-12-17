<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Prefecture;
use App\Models\Region;

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
        $json = Storage::disk('local')->get('new_city.json');
        $japan = json_decode($json, true);

        $index = 0;

        foreach($japan as $region) {
            
            Region::create([
                'name' => $region['name'],
                'slug' => $region['slug'],
            ]);
            
            $index++;
                
            foreach($region['prefs'] as $pref) {

                Prefecture::create([
                    'region_id' => $index,
                    'name' => $pref['name'],
                    'slug' => $pref['slug'],
                ]);

                foreach($pref['cities'] as $city){
                    City::create([
                        'name' => $city['name'],
                        'slug' => $city['slug'],
                        'prefecture' => $pref['slug'],
                        'region' => $region['slug'],
                        
                        'pop' => filter_var($city['pop'], FILTER_SANITIZE_NUMBER_INT),
                        'land'=> filter_var($city['land'], FILTER_SANITIZE_NUMBER_INT),
                        'jp' => filter_var($city['jp'], FILTER_SANITIZE_NUMBER_INT),
                        'household'=> filter_var($city['household'], FILTER_SANITIZE_NUMBER_INT),
                        'yo_school'=> filter_var($city['yo-school'], FILTER_SANITIZE_NUMBER_INT),
                        'sho_school' => filter_var($city['sho-school'], FILTER_SANITIZE_NUMBER_INT),
                        'chu_school' => filter_var($city['chu-school'], FILTER_SANITIZE_NUMBER_INT),
                        'ko_school' => filter_var($city['ko-school'], FILTER_SANITIZE_NUMBER_INT),
                        'empty' => filter_var($city['empty'], FILTER_SANITIZE_NUMBER_INT),
                        'kominkan' => filter_var($city['kominkan'], FILTER_SANITIZE_NUMBER_INT),
                        'toshokan' => filter_var($city['toshokan'], FILTER_SANITIZE_NUMBER_INT),
                        'forest' => filter_var($city['forest'], FILTER_SANITIZE_NUMBER_INT),
                        'portal' => $city['portal'],
                        'hospital' => filter_var($city['hospital'], FILTER_SANITIZE_NUMBER_INT),
                        'clinic' => filter_var($city['clinic'], FILTER_SANITIZE_NUMBER_INT),
        
                    ]);

                }
            }
        }
    }
}
