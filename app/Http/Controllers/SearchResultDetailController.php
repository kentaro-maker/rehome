<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class SearchResultDetailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(int $id = null)
    {
        $city = City::find($id);
        return view('search_result_detail', compact('city'));
    }
}
