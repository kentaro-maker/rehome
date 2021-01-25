<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\Apply;
use App\Models\Review;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\Answer;
use App\Http\Requests\StoreComment;
use App\Http\Requests\StoreQuestionnaire;
use App\Http\Requests\StoreAnswers;
use App\Http\Requests\StoreReview;
use App\Http\Requests\CreateEventRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth')->except(['search','detail']);
    }

    public function search()
    {
        $result = Event::with(['host','likes','applies'])->paginate(10);
        // Log::debug('sear',[$result]);
        // Log::debug('use',[Auth::user()]);
        return $result;
    }

    public function detail($id)
    {
        $event = Event::where('id', $id)->with(['host','comments.author','likes'])->first();

        return $event ?? abort(404);
    }

    public function create(CreateEventRequest $request)
    {
        $event = new Event();

        $event->title = $request->title;

        DB::beginTransaction();

        try {
            Auth::user()->events()->save($event);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        // リソースの新規作成なので
        // レスポンスコードは201(CREATED)を返却する
        return response($event, 201);
    }

    public function hosted(){
        $events = Auth::user()->events()->with(['applies'])->paginate(10);
        return $events;
    }

    public function participated(){
        $events = Auth::user()->applies()->with('event')->paginate(10);
        $events->each(function ($item, $key) {
            $ticket = Ticket::where([
                ['event_id', $item->event_id],
                ['user_id',Auth::user()->id]
                ])->first();
            $item->ticket = $ticket;
        });
        // Log::debug('message',[$events]);
        // Log::debug('message',[Auth::user()->applies()]);
   
        return $events;
    }

    public function liked(){
        $events = Event::whereHas('likes', function($query) {
            $query->where('user_id', Auth::user()->id);
        })->paginate(10);
        Log::debug('j',[$events]);
       
        return $events;
    }

    public function addComment(Event $event, StoreComment $request)
    {
        $comment = new Comment();
        $comment->content = $request->get('content');
        $comment->user_id = Auth::user()->id;

        $event->comments()->save($comment);

        // authorリレーションをロードするためにコメントを取得しなおす
        $new_comment = Comment::where('id', $comment->id)->with('author')->first();

        return response($new_comment, 201);
    }

    public function addQuestionnaire(Event $event, StoreQuestionnaire $request)
    {
        $event = Event::where('id', $event->id)->first();
        if (! $event) {
            abort(404);
        }

        // Log::debug('request',[$request->questions]);
        $questionnaire = new Questionnaire();
        $event->questionnaire()->save($questionnaire);
        foreach($request->questions as $q){
            $question = new Question();
            $question->questionnaire_id = $questionnaire->id;
            // Log::debug('id',[$questionnaire]);
            $question->content = $q['content'];
            $questionnaire->questions()->save($question);
        }

        // Log::debug('questionnaire',[Questionnaire::all()]);
        // Log::debug('question',[Question::all()]);
        
        // $event->comments()->save($comment);
        
        $new_questionnaire = Questionnaire::where('id', $questionnaire->id)
        ->with(['questions'])
        ->get();
        // Log::debug('new',[$new_questionnaire]);

        return response($new_questionnaire, 201);
    }

    public function answer(Event $event, StoreAnswers $request){
        // Log::debug('request',[$request]);
        $event = Event::where('id', $event->id)->first();
        if (! $event) {
            abort(404);
        }

        $query = Answer::query();
        foreach($request->answers as $a){
            $answer = new Answer();
            $answer->user_id = Auth::user()->id;
            $answer->content = $a['content'];
            $query->orWhere('question_id',$a['id']);
            $question = Question::where('id',$a['id'])->first();
            $question->answers()->save($answer);
        }


        $new_answer = $query->get();
        // Log::debug('nnew',[$query->get()]);
        return response($new_answer, 201);
    }

    public function review(Event $event, StoreReview $request){
        // Log::debug('request',[$request]);
        $event = Event::where('id', $event->id)->first();
        if (! $event) {
            abort(404);
        }

        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->stars = $request->stars;
        $review->content = $request->content;
        $event->reviews()->save($review);

        $new_reviews = $event->reviews;
        
        return response($new_reviews, 201);
    }

    /**
     * いいね
     * @param $id
     * @return array
     */
    public function like($id)
    {
        $event = Event::where('id', $id)->with('likes')->first();
        if (! $event) {
            abort(404);
        }
        
        $event->likes()->detach(Auth::user()->id);
        $event->likes()->attach(Auth::user()->id);

        return ["event_id" => $event->id];
    }

    /**
     * いいね解除
     * @param  $id
     * @return array
     */
    public function unlike($id)
    {
        $event = Event::where('id', $id)->with('likes')->first();

        if (! $event) {
            abort(404);
        }

        $event->likes()->detach(Auth::user()->id);

        // $idは数値だが、受取側JSONでは文字列に変換されて送信されるため注意
        return ["event_id" => $event->id];
    }

    /**
     * 参加申込
     * @param $id
     * @return array
     */
    public function apply($id)
    {
        $event = Event::where('id', $id)->with('applies')->first();
        if (! $event) {
            abort(404);
        }
        if($event->applies->contains(Auth::user()->id)){
            return ["event_id" => $event->id];
        }
        $apply = new Apply();
        $apply->user_id = Auth::user()->id;
        $apply->approved = null;

        $event->applies()->save($apply);

        $new_event = Event::all();
        // Log::debug('e',[$new_event]);


        return ["event_id" => $event->id];
    }

    /**
     * 参加申込書解除
     * @param  $id
     * @return array
     */
    public function unapply($id)
    {
        $event = Event::where('id', $id)->with('applies')->first();

        if (! $event) {
            abort(404);
        }
        
        $applies_HasMany = Auth::user()->applies();
        // Log::debug('applies',[Auth::user()->applies]);
        // Log::debug('applies',[Auth::user()->applies->contains('event_id',$event->id)]);
        // Log::debug('event',[$event->id]);
        if($applies_HasMany->get()->contains('event_id',$event->id)){
            // Log::debug('message',[Auth::user()->applies()]);
            $applies_HasMany->where('event_id', $event->id)->delete();
            return ["event_id" => $event->id];
        }
        return ["event_id" => $event->id];
    }

    /**
     * 参加申込承認
     * @param $id
     * @return array
     */
    public function approve($event_id,$user_id)
    {
        $event = Event::where('id', $event_id)->with('applies')->first();
        if (! $event) {
            abort(404);
        }
        $applies = $event->applies;
        $apply = $applies->firstWhere('user_id',$user_id);
        $apply->approved = true;
        $apply->save();
        Log::debug('message',[$apply]);
        return [
            'event_id' => $event->id,
            'user_id' => $user_id
        ];
    }

    /**
     * 参加申込承認解除
     * @param  $id
     * @return array
     */
    public function unapprove($event_id, $user_id)
    {
        $event = Event::where('id', $event_id)->with('applies')->first();

        if (! $event) {
            abort(404);
        }
        $applies = $event->applies;
        $apply = $applies->firstWhere('user_id',$user_id);
        $apply->approved = null;
        $apply->save();
        Log::debug('message',[$apply]);
        return [
            'event_id' => $event->id,
            'user_id' => $user_id
        ];
    }

    /**
     * 参加申込拒否
     * @param $id
     * @return array
     */
    public function decline($event_id,$user_id)
    {
        $event = Event::where('id', $event_id)->with('applies')->first();
        if (! $event) {
            abort(404);
        }
        $applies = $event->applies;
        $apply = $applies->firstWhere('user_id',$user_id);
        $apply->approved = false;
        $apply->save();
        Log::debug('message',[$apply]);
        return [
            'event_id' => $event->id,
            'user_id' => $user_id
        ];
    }

    /**
     * 参加申込拒否解除
     * @param  $id
     * @return array
     */
    public function undecline($event_id, $user_id)
    {
        $event = Event::where('id', $event_id)->with('applies')->first();

        if (! $event) {
            abort(404);
        }
        $applies = $event->applies;
        $apply = $applies->firstWhere('user_id',$user_id);
        $apply->approved = null;
        $apply->save();
        Log::debug('message',[$apply]);
        return [
            'event_id' => $event->id,
            'user_id' => $user_id
        ];
    }

    /**
     * チケットを購入
     * @param  $id
     * @return array
     */
    public function purchase($event_id)
    {
        $event = Event::where('id', $event_id)->with('applies')->first();

        if (! $event) {
            abort(404);
        }
        
        
        // Log::debug('be',[$event_id]);
        // Log::debug('in',[Ticket::where([['event_id',$event_id],['user_id',Auth::user()->id]])->first()]);
        $ticket =  Ticket::where([['event_id',$event_id],['user_id',Auth::user()->id]])->first();
        if($ticket){
            return ['event_id',$event_id];
        }
        if($event->applies->contains('user_id',Auth::user()->id)){
            $apply = Apply::where('user_id', Auth::user()->id)->first();
            if($apply->approved){
                $ticket = new Ticket();
                $ticket->event_id = $event->id;
                $ticket->code = "00000000";
                $ticket->validated = null;
                Auth::user()->tickets()->save($ticket);

                return [
                    "ticket" => $ticket,
                    "event_id" => $event->id
                ];
            }
            }
        // Log::debug('af',[Auth::user()->tickets]);
        return ["event_id" => $event->id];
    }

    /**
     * チケットを購入拒否
     * @param  $id
     * @return array
     */
    public function unpurchase($event_id)
    {
        $event = Event::where('id', $event_id)->with('applies')->first();

        if (! $event) {
            abort(404);
        }
        
        Log::debug('be',[$event_id]);
        Log::debug('in',[Ticket::where([['event_id',$event_id],['user_id',Auth::user()->id]])->first()]);
        $ticket =  Ticket::where([['event_id',$event_id],['user_id',Auth::user()->id]])->first();
        if($ticket){
            $ticket->delete();
            return ['event_id' => $event_id];
        }
        Log::debug('af',[Auth::user()->tickets]);
        return ["event_id" => $event->id];
    }
}
