<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // ★ 追記
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Event extends Model
{
    use HasFactory;

    /** JSONに含めるアクセサ */
    protected $appends = [
        'likes_count',
        'liked_by_user',
        'hosted_by_user',
        'applied_by_user',
        'purchased_by_user',
        'participants',
    ];
    
    protected $visible = [
        'id','title','host','comments',
        'likes_count',
        'liked_by_user',
        'hosted_by_user',
        'applied_by_user',
        'purchased_by_user',
        'participants',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function questionnaire()
    {
        return $this->hasOne(Questionnaire::class);
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }

    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applies()
    {
        return $this->hasMany(Apply::class);
    }

    /**
     * リレーションシップ - commentsテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('id', 'desc');
    }

    /**
     * アクセサ - likes_count
     * @return int
     */
    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    /**
     * アクセサ - liked_by_user
     * @return boolean
     */
    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->likes->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    /**
     * アクセサ - applied_by_user
     * @return boolean
     */
    public function getAppliedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->applies->contains(function ($apply) {
            return $apply->user_id === Auth::user()->id;
        });
    }

    /**
     * アクセサ - hosted_by_user
     * @return boolean
     */
    public function getHostedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        // $this == Event::class
        return $this->user_id === Auth::user()->id;
    }

    /**
     * アクセサ - hosted_by_user
     * @return boolean
     */
    public function setHostedByUserAttribute($is_hosted)
    {
        $this->hosted_by_user = $is_hosted;
    }

    /**
     * アクセサ - purchased_by_user
     * @return boolean
     */
    public function getPurchasedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        $ticket  = Ticket::where([['event_id',$this->id],['user_id',Auth::user()->id]])->first();
        if($ticket){
            return true;
        }else{
            return false;
        }
        //return $this->user_id === Auth::user()->id;
    }

    /**
     * アクセサ - participants
     * @return boolean
     */
    public function getParticipantsAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        //  Log::debug('message',[$this->applies]);
        $applies = $this->applies;
        $new_applies = $applies->map(function($item,$key){
            $item->name = $item->participant->name;
            // Log::debug('item',[$item->participant->name]);
            return $item; 
        });
        // Log::debug('new',[$new_applies->makeVisible('name')->makeHidden(['id','event_id'])]);
        return $new_applies->makeVisible('name')->makeHidden(['id','event_id']);
    }
}
