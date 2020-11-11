<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->name('landing-page');

Route::get('/city', [App\Http\Controllers\CityController::class, 'index'])->name('city.index');
Route::get('/city/{city?}', [App\Http\Controllers\CityController::class, 'show'])->name('city.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::get('/search/result', [App\Http\Controllers\SearchResultController::class, 'index'])->name('search.result');
Route::get('/search/result/{id}', [App\Http\Controllers\SearchResultDetailController::class, 'index'])->name('search.result.detail');
Route::get('/search/result/{id}/pdf', [App\Http\Controllers\PdfController::class, 'index'])->name('pdf.output');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::get('/profile/edit', [App\Http\Controllers\ProfileEditController::class, 'index'])->name('profileEdit');
Route::get('/profile/delete', [App\Http\Controllers\ProfileDeleteController::class, 'index'])->name('profileDelete');

Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
