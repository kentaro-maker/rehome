<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::take(8)->inRandomOrder()->get();

        return view('landing-page')->with('cities', $cities);
    }
}
