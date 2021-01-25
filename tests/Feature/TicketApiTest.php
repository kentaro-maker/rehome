<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Apply;
use Illuminate\Support\Str;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;


class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->participant = User::factory()->create();
    }

   /**
     * @test
     */
    public function should_チケットを取得しトークンを付与できる()
    {
        Event::factory()->create();
        $event = Event::first();

        $apply = new Apply();
        $apply->user_id = $this->participant->id;
        $apply->approved = true;
        
        $event->applies()->save($apply);

        $ticket = new Ticket();
        $ticket->event_id = $event->id;
        $ticket->code = "00000000";
        $ticket->validated = null;
        $this->participant->tickets()->save($ticket);

        $response = $this->actingAs($this->participant)
            ->json('get', route('ticket.fetch', [
                'event_id' => $event->id,
                'ticket_id' => $ticket->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'code' => $ticket->code,
                'validated' => $ticket->validated,
        ]);

        $this->assertTrue(
            strlen($response->original->token) == 100,
            "トークン文字列長が100ではない。length=". strlen($response->original->token)
        );

        $this->assertEquals(1, $this->participant->tickets()->count());
    }

    /**
     * @test
     */
    public function should_チケットの認証ができる()
    {
        Event::factory()->create();
        $event = Event::first();

        // 申し込みの登録
        $apply = new Apply();
        $apply->user_id = $this->participant->id;
        $apply->approved = true;
        $event->applies()->save($apply);

        // チケットの登録
        $ticket = new Ticket();
        $ticket->event_id = $event->id;
        $ticket->code = "00000000";
        $ticket->validated = null;
        $this->participant->tickets()->save($ticket);

        $user = User::find($event->id);

        $code = '00000000';

        $response = $this->actingAs($user)
            ->json('POST', route('ticket.validate', [
                'event' => $event->id,
            ]), compact('code'));

        // Log::debug('response',[$response]);
        $response->assertStatus(200);

        // $this->assertTrue(
        //     strlen($response->original->token) == 100,
        //     "トークン文字列長が100ではない。length=". strlen($response->original->token)
        // );

        // $this->assertEquals(1, $this->participant->tickets()->count());
    }

}
