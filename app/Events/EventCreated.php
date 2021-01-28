<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;

class EventCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;

    public $afterCommit = true;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = new \stdClass();
        $this->event->id = $event->id;
        $this->event->title = $event->title;
        $this->event->likes_count = 0;
        $this->event->liked_by_user = false;
        $this->event->hosted_by_user = false;
        $this->event->applied_by_user = false;
        $this->event->applied_by_user = false;
        $this->event->purchased_by_user = false;
        $this->event->participants = [];
    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        Log::debug('event',[$this->event]);
        return new Channel('event-created', $this->event);
    }
}
