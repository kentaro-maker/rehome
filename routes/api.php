<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// トークンリフレッシュ
Route::get('/reflesh-token', function (Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();

    return response()->json();
});

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/user', fn() => Auth::user())->name('user');

Route::get('/event/search',[App\Http\Controllers\EventController::class, 'search'])->name('event.search');
Route::get('/event/detail/{id}',[App\Http\Controllers\EventController::class, 'detail'])->name('event.detail');

Route::get('/event/hosted',[App\Http\Controllers\EventController::class, 'hosted'])->name('event.hosted');
Route::post('/event/create',[App\Http\Controllers\EventController::class, 'create'])->name('event.create');

// いいね
Route::put('/events/{id}/like', [App\Http\Controllers\EventController::class, 'like'])->name('event.like');
// いいね解除
Route::delete('/events/{id}/like', [App\Http\Controllers\EventController::class, 'unlike']);

Route::post('/search', [App\Http\Controllers\CityController::class,'search']);
Route::get('/region/{slug}', [App\Http\Controllers\CityController::class,'index'])->name('city.index');
Route::get('/region/{region_slug}/pref/{pref_slug}', [App\Http\Controllers\CityController::class,'pref'])->name('city.pref');
Route::get(
    '/region/{region_slug}/pref/{pref_slug}/city/{city_slug}', 
    [App\Http\Controllers\CityController::class,'detail']
    )->name('city.detail');



