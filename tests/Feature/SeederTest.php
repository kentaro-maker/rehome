<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_上手いことシードできる()
    {
        User::factory(5)
            ->has(Event::factory()->count(3))
            ->create();

        $users = DB::table('users')
            ->leftJoin('events', 'users.id', '=', 'events.user_id')
            ->select('users.id', 'users.name','events.user_id','events.title')
            ->get();
        $events = Event::all();
        Log::debug('events',[$events]);
        Log::debug('users',[$users]);

        $this->assertDatabaseCount('users', 5);

    }
}
