<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Event;
use App\Models\Apply;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

class PurchaseTicketApiTest extends TestCase
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
    public function should_チケットを購入できる()
    {
        $event = Event::factory()->create();

        $apply = new Apply();
        $apply->user_id = $this->participant->id;
        $apply->approved =true;
        $event->applies()->save($apply);

        $response = $this->actingAs($this->participant)
            ->json('PUT', route('event.purchase', [
                'event_id' => $event->id,
                'apply_id' => $apply->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'event_id' => $event->id,
            ]);

        $this->assertEquals(1, $this->participant->tickets()->count());
    }
}
