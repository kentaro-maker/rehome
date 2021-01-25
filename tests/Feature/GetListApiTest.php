<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Apply;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class GetListApiTest extends TestCase
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
    public function should_イベント一覧を参加申請又は参加しているユーザーと同時に取得できる()
    {
        // イベント作成
        Event::factory()->create();
        $event = Event::first();
        $param = [
            'id' => $event->id,
        ];

        $this->actingAs(User::factory()->create())->json('PUT', route('event.apply', $param));
        $this->actingAs(User::factory()->create())->json('PUT', route('event.apply', $param));
        $this->actingAs(User::factory()->create())->json('PUT', route('event.apply', $param));
        $this->actingAs(User::factory()->create())->json('PUT', route('event.apply', $param));
        $this->actingAs(User::factory()->create())->json('PUT', route('event.apply', $param));
        
        $users = DB::table('users')
        ->join('applies', 'users.id', '=', 'applies.user_id')
        ->join('events', 'events.user_id', '=', 'applies.user_id')
        ->select('users.name')
        ->get();

        // イベント主催者を取得
        Log::debug('host',[$users]);
        Log::debug('applies',[DB::table('applies')
        ->join('events','applies.event_id','=','events.id')
        ->where('events.id',$event->id)
        ->select('applies.user_id','applies.approved')
        ->get()]);

    }
}
