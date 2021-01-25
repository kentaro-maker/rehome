<?php

namespace Tests\Feature;


use App\Models\Event;
use App\Models\User;
use App\Models\Apply;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

class ApproveApplyApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->host = User::factory()->create();
        $this->participant = User::factory()->create();

    }
    
    /**
     * @test
     */
    public function should_イベント参加申し込みを承認できる()
    {
        Event::factory()->create();
        $event = Event::first();

        $apply = new Apply();
        $apply->user_id = $this->participant->id;
        $apply->approved = null;
        
        $event->applies()->save($apply);

        $response = $this->actingAs($this->host)
            ->json('PUT', route('user.approve', [
                'event_id' => $event->id,
                'user_id' => $this->participant->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'event_id' => $event->id,
            ]);

        $this->assertEquals(1, $event->applies()->count());
    }

   
}
