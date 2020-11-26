<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prefecture;

class PrefectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 参考URL
        // https://ja.wikipedia.org/wiki/%E6%97%A5%E6%9C%AC%E3%81%AE%E5%9C%B0%E5%9F%9F
        $prefectures = [
            [1,'北海道','hokkaido'],
            [2,'青森県','aomori'],
            [2,'岩手県','iwate'],
            [2,'宮城県','miyagi'],
            [2,'秋田県','akita'],
            [2,'山形県','yamagata'],
            [2,'福島県','fukushima'],
            [3,'茨城県','ibaragi'],
            [3,'栃木県','tochigi'],
            [3,'群馬県','gumma'],
            [3,'埼玉県','saitama'],
            [3,'千葉県','chiba'],
            [3,'東京都','tokyo'],
            [3,'神奈川県','kanagawa'],
            [4,'新潟県','nigata'],
            [4,'長野県','nagano'],
            [4,'山梨県','yamagata'],
            [5,'富山県','toyama'],
            [5,'石川県','ishigawa'],
            [5,'福井県','fukui'],
            [6,'岐阜県','gifu'],
            [6,'静岡県','shizuoka'],
            [6,'愛知県','aichi'],
            [6,'三重県','mie'],
            [7,'滋賀県','shiga'],
            [7,'京都府','kyoto'],
            [7,'大阪府','osaka'],
            [7,'兵庫県','hyogo'],
            [7,'奈良県','nara'],
            [7,'和歌山県','wakayama'],
            [8,'鳥取県','tottori'],
            [8,'島根県','shimane'],
            [8,'岡山県','okayama'],
            [8,'広島県','hiroshima'],
            [8,'山口県','yamagata'],
            [9,'徳島県','tokui'],
            [9,'香川県','kagawa'],
            [9,'愛媛県','ehime'],
            [9,'高知県','kochi'],
            [10,'福岡県','fukuoka'],
            [10,'佐賀県','saga'],
            [10,'長崎県','nagasaki'],
            [10,'熊本県','kumamoto'],
            [10,'大分県','oita'],
            [10,'宮崎県','miyazaki'],
            [10,'鹿児島県','kagoshima'],
            [10,'沖縄県','okinawa'],
        ];

        foreach ($prefectures as $prefecture) {
            Prefecture::create([
                'region_id' => $prefecture[0],
                'name' => $prefecture[1],
                'slug' => $prefecture[2],
            ]);
        }

        
    }
}
