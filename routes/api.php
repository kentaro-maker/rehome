<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Events\TicketValidated;

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
Route::get('/event/participated',[App\Http\Controllers\EventController::class, 'participated'])->name('event.participated');
Route::get('/event/liked',[App\Http\Controllers\EventController::class, 'liked'])->name('event.liked');
Route::post('/event/create',[App\Http\Controllers\EventController::class, 'create'])->name('event.create');

Route::post('/events/{event}/comments', [App\Http\Controllers\EventController::class, 'addComment'])->name('event.comment');
Route::post('/events/{event}/questionnaire', [App\Http\Controllers\EventController::class, 'addQuestionnaire'])->name('event.questionnaire');
Route::post('/events/{event}/answer', [App\Http\Controllers\EventController::class, 'answer'])->name('event.answer');
Route::post('/events/{event}/review', [App\Http\Controllers\EventController::class, 'review'])->name('event.review');

// いいね
Route::put('/events/{id}/like', [App\Http\Controllers\EventController::class, 'like'])->name('event.like');
// いいね解除
Route::delete('/events/{id}/like', [App\Http\Controllers\EventController::class, 'unlike']);

// 承認待ちのユーザー

// イベント参加申し込み
Route::put('/events/{id}/apply', [App\Http\Controllers\EventController::class, 'apply'])->name('event.apply');
// イベント参加解除
Route::delete('/events/{id}/apply', [App\Http\Controllers\EventController::class, 'unapply']);
// イベント参加承認
Route::put('/event/{event_id}/user/{user_id}/approve', [App\Http\Controllers\EventController::class, 'approve'])->name('user.approve');
// イベント参加承認解除
Route::delete('/event/{event_id}/user/{user_id}/approve', [App\Http\Controllers\EventController::class, 'unapprove']);
// イベント参加拒否
Route::put('/event/{event_id}/user/{user_id}/decline', [App\Http\Controllers\EventController::class, 'decline'])->name('user.decline');
// イベント参加拒否解除
Route::delete('/event/{event_id}/user/{user_id}/decline', [App\Http\Controllers\EventController::class, 'undecline']);
// イベント参加確定チケット購入
Route::put('/event/{event_id}/purchase', [App\Http\Controllers\EventController::class, 'purchase'])->name('event.purchase');
// イベント参加確定
Route::delete('/event/{event_id}/purchase', [App\Http\Controllers\EventController::class, 'unpurchase']);

Route::get('/events/{event_id}/tickets/{ticket_id}', [App\Http\Controllers\TicketController::class, 'fetch'])->name('ticket.fetch');

Route::post('/event/{event}/validate', [App\Http\Controllers\TicketController::class, 'ticketValidate'])->name('ticket.validate');

Route::post('/search', [App\Http\Controllers\CityController::class,'search']);
Route::get('/region/{slug}', [App\Http\Controllers\CityController::class,'index'])->name('city.index');
Route::get('/region/{region_slug}/pref/{pref_slug}', [App\Http\Controllers\CityController::class,'pref'])->name('city.pref');
Route::get(
    '/region/{region_slug}/pref/{pref_slug}/city/{city_slug}', 
    [App\Http\Controllers\CityController::class,'detail']
    )->name('city.detail');




// 写真ダウンロード
Route::get('/cities/{city_id}/pdf', [App\Http\Controllers\PdfController::class,'index'])->name('pdf.download');

Route::get('/ticket', function () {event(new TicketValidated);});
