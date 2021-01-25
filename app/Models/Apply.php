<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // ★ 追記
use Illuminate\Support\Facades\Log;

class Apply extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'approved'
    ];

    protected $appends = [
        // 'event'
    ];

    /** JSONに含める属性 */
    protected $visible = [
         'id','user_id','event_id','approved','event','ticket'
   ];

    public function getApprovedAttribute($value)
    {
        return $value;
    }

    public function setApprovedAttribute($value)
    {
        $this->attributes['approved'] = $value;
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id', 'events');
    }
    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }

   /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }
    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }

    /**
     * アクセサ - event
     * @return boolean
     */
    public function getEventAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        Log::debug('message',[$this->event]);
        return $this->event->makeHidden(['id','hosted_by_user','participants']);
    }

}
