<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
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
    public function index()
    {
        $user = Auth::User();
        return view('profile', [
          'user'                  => $user,
          'name'                  => $user->name,
          'gender'                => $user->gender,
          'age'                   => $user->age,
          'birthplace'            => $user->birthplace,
          'residence'             => $user->residence,
          'occupation'            => $user->occupation,
          'communing_time'        => $user->communing_time,
          'living_style'          => $user->living_style,
          'annual_income'         => $user->annual_income,
          'marriage_status'       => $user->marriage_status,
          'household_composition' => $user->household_composition,
          'email'                 => $user->email,
        ]);
    }
}
