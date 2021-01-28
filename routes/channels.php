<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Event;
use App\Models\Apply;
use App\Models\Ticket;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('ticketValidate.{userId}', function($user, $id){
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user-applied-event.{eventId}', function($user, $eventId){
    return (int) $user->id === Event::find($eventId)->user_id;
});

Broadcast::channel('user-approved-apply.{applyId}', function($user, $applyId){
    return (int) $user->id === Apply::find($applyId)->user_id;
});

Broadcast::channel('ticket-validated.{ticketId}', function($user, $ticketId){
    return (int) $user->id === Ticket::find($ticketId)->user_id;
});