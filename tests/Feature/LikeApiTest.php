<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

class LikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        Event::factory()->create();
        $this->event = Event::first();
    }

    /**
     * @test
     */
    public function should_いいねを追加できる()
    {
        $response = $this->actingAs($this->user)
            ->json('PUT', route('event.like', [
                'id' => $this->event->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'event_id' => $this->event->id,
            ]);

        $this->assertEquals(1, $this->event->likes()->count());
    }

    /**
     * @test
     */
     public function should_2回同じイベントにいいねしても1個しかいいねがつかない()
     {
        $param = ['id' => $this->event->id];
        $this->actingAs($this->user)->json('PUT', route('event.like', $param));
        $this->actingAs($this->user)->json('PUT', route('event.like', $param));
        
        $this->assertEquals(1, $this->event->likes()->count());
    }
    
    /**
     * @test
     */
     public function should_いいねを解除できる()
     {
         $this->event->likes()->attach($this->user->id);
         
        $response = $this->actingAs($this->user)
        ->json('DELETE', route('event.like', [
                'id' => $this->event->id,
                ]));
            
        $response->assertStatus(200)
            ->assertJsonFragment([
                'event_id' => $this->event->id,
            ]);

        $this->assertEquals(0, $this->event->likes()->count());
    }
}