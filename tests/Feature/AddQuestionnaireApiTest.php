<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Questionnaire;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

class AddQuestionnaireApiTest extends TestCase
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
    public function should_アンケートを追加できる()
    {
        Event::factory()->create();
        $event = Event::first();
        $user = User::where('id',$event->id)->first();

        $questions = array(
            array('id'=>1,'content'=>'また参加したいですか。'),
            array('id'=>2,'content'=>'次回に期待することはありますか'));

        $response = $this->actingAs($user)
            ->json('POST', route('event.questionnaire', [
                'event' => $event->id,
            ]), compact('questions'));

        $questionnaire = $event->questionnaire()->with('questions')->get();

        // Log::debug('response',[$response]);
        $response->assertStatus(201)
            // JSONフォーマットが期待通りであること
            ->assertJsonFragment([
                'content' => $questions[0]['content'],
                'content' => $questions[1]['content']
            ]);

        // Log::debug('ques',[$questionnaire->first()->questions->toArray()]);
        // DBにコメントが1件登録されていること
        $this->assertEquals(1, $questionnaire->count());
        // 内容がAPIでリクエストしたものであること
        $this->assertEquals($questions, $questionnaire->first()->questions->toArray());
    }
}
