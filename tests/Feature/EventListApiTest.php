<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


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
    public function should_正しい構造のすべてのイベントJSONを返却する()
    {
        // 5つの写真データを生成する
        Event::factory(5)->create();
        $response = $this->json('GET', route('event.search'));
        $response->assertStatus(200)
            ->assertJsonFragment([
                'liked_by_user' => false,
                'likes_count' => 0,
            ]);
    }

    /**
     * @test
     */
    public function should_正しい構造のイベント詳細JSONを返却する()
    {
        Event::factory()->create()->each(function ($event) {
            $event->comments()->saveMany(Comment::factory(3)->make());
        });

        $event = Event::first();
       
        //Log::debug('event',[$event->comments]);

        $response = $this->json('GET', route('event.detail',[
            'id' => $event->id
            ]));


        //Log::debug('response',[$response]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                    'host' => [
                        'name' => $event->host->name,
                    ],
                    'comments' => $event->comments
                    ->sortByDesc('id')
                    ->map(function ($comment) {
                        return [
                            'author' => [
                                'name' => $comment->author->name,
                            ],
                            'content' => $comment->content,
                        ];
                    })
                    ->all(),
                    'liked_by_user' => false,
                    'likes_count' => 0,
            ]);
    }

    /**
     * @test
     */
    public function should_正しい構造の主催しているイベントJSONを返却する()
    {
        $events = Event::factory(5)
        ->state([
            // ここで半日つまった
            'user_id' => $this->user->id
        ])
        ->create();

        $response = $this->actingAs($this->user)
            ->json('GET', route('event.hosted'));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'liked_by_user' => false,
                'likes_count' => 0,
            ]);
    }
}
