<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\CreateEventRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth');
    }

    public function create(CreateEventRequest $request)
    {
        $event = new Event();

        $event->title = $request->title;

        DB::beginTransaction();

        try {
            Auth::user()->events()->save($event);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        // リソースの新規作成なので
        // レスポンスコードは201(CREATED)を返却する
        return response($event, 201);
    }

    public function hosted(){
        $events = Auth::user()->events()->paginate();
        Log::debug('events',[$events]);
        return $events;
    }
}
