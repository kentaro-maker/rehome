<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $visible = [
        'id','name',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function events(){
        return $this->hasMany(Event::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function likes()
    {
        return $this->belongsToMany(Event::class, 'likes')->withTimestamps();
    }

    public function applies()
    {
        return $this->hasMany(Apply::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
