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
        $this->middleware('auth')->except(['search','detail']);
    }

    public function search()
    {
        $result = Event::with(['host','likes'])->paginate(10);
        return $result;
    }

    public function detail($id)
    {
        $event = Event::where('id', $id)->with(['host','likes'])->first();

        return $event ?? abort(404);
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
        $events = Auth::user()->events()->with(['host'])->paginate(5);
        return $events;
    }

    /**
     * いいね
     * @param $id
     * @return array
     */
    public function like($id)
    {
        $event = Event::where('id', $id)->with('likes')->first();
        if (! $event) {
            abort(404);
        }
        
        $event->likes()->detach(Auth::user()->id);
        $event->likes()->attach(Auth::user()->id);

        return ["event_id" => $event->id];
    }

    /**
     * いいね解除
     * @param  $id
     * @return array
     */
    public function unlike($id)
    {
        $event = Event::where('id', $id)->with('likes')->first();

        if (! $event) {
            abort(404);
        }

        $event->likes()->detach(Auth::user()->id);

        // $idは数値だが、受取側JSONでは文字列に変換されて送信されるため注意
        return ["event_id" => $event->id];
    }
}
