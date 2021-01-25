<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Answer;
use App\Models\Questionnaire;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

class AddAnswersApiTest extends TestCase
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
    public function should_アンケートを答えられる()
    {
        Event::factory()->create();
        $event = Event::first();

        $questions = array(
            array('id'=>1,'content'=>'また参加したいですか。'),
            array('id'=>2,'content'=>'次回に期待することはありますか'));

        $questionnaire = new Questionnaire();
        $event->questionnaire()->save($questionnaire);
        foreach($questions as $q){
            $question = new Question();
            $question->questionnaire_id = $questionnaire->id;
            $question->content = $q['content'];
            $questionnaire->questions()->save($question);
        }

        $answers = array(
            array('id'=>1,'content'=>'はい'),
            array('id'=>2,'content'=>'いいえ')
        );

        $response = $this->actingAs($this->user)
            ->json('POST', route('event.answer', [
                'event' => $event->id,
            ]), compact('answers'));

        $response->assertStatus(201)
            // JSONフォーマットが期待通りであること
            ->assertJsonFragment([
                'content' => $answers[0]['content'],
                'content' => $answers[1]['content']
            ]);

        // DBにコメントが2件登録されていること
        $this->assertEquals(2, Answer::count());
    }
}
