<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth')->except(['index','detail']);
    }


    /**
     * 一覧
     */
    public function index($slug)
    {
        // 間違えて %{shi}% ってやって半日無駄にしたってここに記す 2020/11/26 21:47 by Kentaro Ito in Japan
        $cities = City::where('region',$slug)->get();
        Log::debug('cities',[$cities]);
        return $cities;
    }


    /**
     * 詳細
     */
    public function detail($region,$pref,$city)
    {
        $city = City::where('region',$region)
            ->where('prefecture',$pref)
            ->where('slug',$city)
            ->get();
/*
            $city = DB::table('cities')
            ->join('regions', 'regions.slug', '=', 'cities.region')
            ->join('prefectures', 'prefectures.slug', '=', 'cities.prefecture')
            ->select('cities.*', 'cities.slug as city_slug','prefectures.name as prefecture_name', 'regions.name as reigon_name')
            ->where('city_slug',$city)
            ->get();
            */
        Log::debug('city',[$city]);
        return $city;
    }




}
