<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventListApiTest extends TestCase
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
    public function should_正しい構造のイベントJSONを返却する()
    {
        $response = $this->actingAs($this->user)
            ->json('GET', route('event.hosted'));

        $response->assertStatus(200);
    }
}
