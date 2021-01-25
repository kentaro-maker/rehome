<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\Apply;

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
        $this->middleware('auth');
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


    public function ticketValidate(Event $event, TicketValidationRequest $request)
    {
        
        $ticket = $event->tickets()->where('code',$request->code)->first();
        $ticket->validated = true;
        $ticket->save();
        Log::debug('ev',[$event]);
        Log::debug('code',[$request->code]);
        Log::debug('ticket',[$ticket]);
        
        // // authorリレーションをロードするためにコメントを取得しなおす
        // $new_comment = Comment::where('id', $comment->id)->with('author')->first();

         return response($ticket, 200);
    
    }
}
