<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;


     /** JSONに含める属性 */
     protected $visible = [
        'id','event_id','user_id','code', 'validated','token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }

    public function event()
    {
        return belongsTo(Event::class, 'event_id', 'id', 'events');
    }
}
