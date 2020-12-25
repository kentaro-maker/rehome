<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // ★ 追記

class Event extends Model
{
    use HasFactory;

    /** JSONに含めるアクセサ */
    protected $appends = [
        'likes_count', 'liked_by_user', 'hosted_by_user'
    ];

    protected $visible = [
        'id','title','host','likes_count', 'liked_by_user', 'hosted_by_user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
}
