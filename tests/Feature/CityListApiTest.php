<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CityListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_正しい構造のcityJSONを返却する()
    {
        // 5つの写真データを生成する
        City::factory(5)->create();

        $response = $this->json('GET', route('city.index',['slug' => '北海道']));

        // 生成した写真データを作成日降順で取得
        $cities = City::where('slug','LIKE',"%{shi}%")->get();


        // data項目の期待値
        $expected_data = $cities->map(function ($city) {
            return [
                'id' => $city->id,
                /*
                'owner' => [
                    'name' => $photo->owner->name,
                ],
                */
            ];
        })
        ->all();

        $response->assertStatus(200);
    }
}
