<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\Apply;

use App\Events\TicketValidated;

use App\Http\Requests\TicketValidationRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth')->except(['push']);
    }

    public function fetch($event_id, $ticket_id)
    {
        $ticket = Ticket::where('id', $ticket_id)->first();

        if (! $ticket) {
            abort(404);
        }

        if($ticket->user_id != Auth::user()->id){
            abort(455);
        }

        $ticket->token = Str::random(100);

        return $ticket;
    }


    public function ticketValidate($event_id, TicketValidationRequest $request)
    {
        
        $ticket = Event::find($event_id)->tickets()->where('code',$request->code)->first();
        Log::debug('message',[$ticket]);
        $ticket->validated = true;
        $ticket->save();
        
        // // authorリレーションをロードするためにコメントを取得しなおす
        // $new_comment = Comment::where('id', $comment->id)->with('author')->first();

        event(new TicketValidated($ticket));

         return response($ticket, 200);
    }

}
