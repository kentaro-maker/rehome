<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Resources\SearchCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Support\Collection;

use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth')->except(['search','index','detail','pref']);
    }

    public function search(Request $request)
    {
        
        if(empty($request->keyword) and empty($request->pop) and empty($request->land) and empty($request->empty)){
            Log::debug('empty',[$request->keyword]);
            return response('empty',422);
        }elseif (preg_match('/(　)+/', $request->keyword) ) {
            Log::debug('space',[$request->keyword]);
            return response('space',422);
        }

        $pop['min'] = $request->pop ? $request->pop[0] : null;
        $pop['max'] = $request->pop ? $request->pop[1] : null;

        $land['min'] = $request->land ? $request->land[0] : null;
        $land['max'] = $request->land ? $request->land[1] : null;
        
        $empty['min'] = $request->empty ? $request->empty[0] : null;
        $empty['max'] = $request->empty ? $request->empty[1] : null;

        foreach ($pop as $key => $value) {
            if (strpos(strtoupper($value), "K") != false) {
                $value = rtrim($value, "kK");
                $pop[$key] = intval($value) * 1000;
            } else if (strpos(strtoupper($value), "M") != false) {
                $s = rtrim($value, "mM");
                $pop[$key] = intval($value) * 1000000;
            }
        }

        foreach ($land as $key => $value) {
            if (strpos(strtoupper($value), "K") != false) {
                $value = rtrim($value, "kK");
                $land[$key] = intval($value) * 1000;
            } else if (strpos(strtoupper($value), "M") != false) {
                $s = rtrim($value, "mM");
                $land[$key] = intval($value) * 1000000;
            }
        }

        foreach ($empty as $key => $value) {
            if (strpos(strtoupper($value), "K") != false) {
                $value = rtrim($value, "kK");
                $empty[$key] = intval($value) * 1000;
            } else if (strpos(strtoupper($value), "M") != false) {
                $s = rtrim($value, "mM");
                $empty[$key] = intval($value) * 1000000;
            }
        }

        // Log::debug('pop',$pop);
        // Log::debug('land',$land);
        // Log::debug('empty',$empty);

        // 省略しちゃう無駄に
        $keyword = $request->keyword;

        $query = DB::table('cities')
            ->join('regions', 'regions.slug', '=', 'cities.region')
            ->join('prefectures', 'prefectures.slug', '=', 'cities.prefecture')
            ->select(
                'cities.*',
                'cities.name as city_name',
                'cities.slug as city_slug',
                'prefectures.name as prefecture_name',
                'prefectures.slug as prefecture_slug',
                'regions.name as region_name',
                'regions.slug as region_slug',
            )
            ->distinct();
        if($keyword) {
            // Log::debug('insidekeyword',[$keyword]);
            $query->where('cities.name','like',"%$keyword%")
            ->orWhere('prefectures.name', 'like', "%$keyword%")
            ->orWhere('regions.name', 'like', "%$keyword%");
        }
        if($pop){
            // Log::debug('insidepop',$pop);
            if($pop['min']){
                $query->where('pop', '>=', $pop['min']);
            }
            if($pop['max']){
                $query->where('pop', '<', $pop['max']);
            }
        }
        if($land){
            // Log::debug('insideland',$land);
            if($land['min']){
                $query->where('land', '>=', $land['min']);
            }
            if($land['max']){
                $query->where('land', '<', $land['max']);
            }
        }
        if($empty){
            // Log::debug('insideempty',$empty);
            if($empty['min']){
                $query->where('empty', '>=', $empty['min']);
            }
            if($empty['max']){
                $query->where('empty', '<', $empty['max']);
            }
        }

        Log::debug('s',[collect($query->get())]);
        $cities = collect($query->get())->paginate(10);

        return $cities;
    }

    /**
     * 一覧
     */
    public function index($slug)
    {
        // 間違えて %{shi}% ってやって半日無駄にした 2020/11/26 21:47 by Kentaro Ito in Japan
        $cities = City::where('region',$slug)->paginate(10);
        //Log::debug('cities',[$cities]);
        return $cities;
    }

    public function pref($region_slug,$pref_slug,$city_slug = null)
    {
        $cities = DB::table('cities')
            ->where([
                ['cities.prefecture', $pref_slug],
                ['cities.region', $region_slug],
            ])
            ->when($city_slug, function ($query, $city_slug) {
                Log::error('when', $city_slug);
                return $query->where('cities.slug',$city_slug);
            })
            ->join('regions', 'regions.slug', '=', 'cities.region')
            ->join('prefectures', 'prefectures.slug', '=', 'cities.prefecture')
            ->select(
                'cities.*',
                'cities.name as city_name',
                'cities.slug as city_slug',
                'prefectures.name as prefecture_name',
                'prefectures.slug as prefecture_slug',
                'regions.name as region_name',
                'regions.slug as region_slug',
                )
            ->paginate(10);
            Log::debug('cc',[$cities]);
            return $cities;
    }

    /**
     * 詳細
     */
    public function detail($region_slug,$pref_slug,$city_slug)
    {
        $city = DB::table('cities')
            ->where([
                ['cities.slug',$city_slug],
                ['cities.prefecture', $pref_slug],
                ['cities.region', $region_slug],
            ])
            ->join('regions', 'regions.slug', '=', 'cities.region')
            ->join('prefectures', 'prefectures.slug', '=', 'cities.prefecture')
            ->select(
                'cities.*',
                'cities.name as city_name',
                'cities.slug as city_slug',
                'prefectures.name as prefecture_name',
                'prefectures.slug as prefecture_slug',
                'regions.name as region_name',
                'regions.slug as region_slug',
                )
            ->get();

            return $city;
    }
}
