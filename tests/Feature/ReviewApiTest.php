<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Answer;
use App\Models\Review;
use App\Models\Questionnaire;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

class ReviewApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = User::factory()->create();
    }

    /**
     * @test
     */
    public function should_イベントにレビューを付けられる()
    {
        Event::factory()->create();
        $event = Event::first();

        $data = [
            'stars' => '3.5',
            'content' => '良い良い',
        ];

        $response = $this->actingAs($this->user)
            ->json('POST', route('event.review', [
                'event' => $event->id,
            ]), $data);

        // Log::debug('message',[$response]);
        // Log::debug('re',[$event->reviews()->where('user_id',$this->user->id)->get()]);
        $response->assertStatus(201)
            // JSONフォーマットが期待通りであること
            ->assertJsonFragment([
                'stars' => $data['stars'],
                'content' => $data['content']
            ]);

        // DBにコメントが2件登録されていること
        $this->assertEquals(1, Review::count());
    }
}
