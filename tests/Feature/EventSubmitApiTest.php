<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

class EventSubmitApiTest extends TestCase
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
    public function should_イベントをアップロードできる()
    {
        $event = Event::factory()->make();
        $data = [
            'title' => $event->title,
        ];
        
        $response = $this->actingAs($this->user)
        ->json('POST', route('event.create'), $data);
        
        // レスポンスが201(CREATED)であること
        $response
                ->assertStatus(201)
                ->assertJson(['title' => $event->title]);
    }
}
