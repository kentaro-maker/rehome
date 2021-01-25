<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Apply;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplyApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
    
    /**
     * @test
     */
    public function should_イベント参加を申し込みできる()
    {
        Event::factory()->create();
        $event = Event::first();

        $response = $this->actingAs($this->user)
            ->json('PUT', route('event.apply', [
                'id' => $event->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'event_id' => $event->id,
            ]);

        $this->assertEquals(1, $event->applies()->count());
    }

    /**
     * @test
     */
     public function should_2回同じイベントに参加を申し込んでも申し込みのまま()
     {
        Event::factory()->create();
        $event = Event::first();

        $param = ['id' => $event->id];
        $this->actingAs($this->user)->json('PUT', route('event.apply', $param));
        $this->actingAs($this->user)->json('PUT', route('event.apply', $param));
        
        
        $this->assertEquals(1, $event->applies()->count());
    }
    
    /**
     * @test
     */
     public function should_イベント参加の申し込みをキャンセルできる()
     {
        Event::factory()->create();
        $event = Event::first();

        $apply = new Apply();
        $apply->user_id = $this->user->id;
        $apply->approved = null;

        $event->applies()->save($apply);
         
        $response = $this->actingAs($this->user)
        ->json('DELETE', route('event.apply', [
                'id' => $event->id, 
                ]));
            
        $response->assertStatus(200)
            ->assertJsonFragment([
                'event_id' => $event->id,
            ]);

        $this->assertEquals(0, $event->applies()->count());
    }
}
