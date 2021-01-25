<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belognsTo(User::class);
    }

    public function event()
    {
        return $this->belognsTo(Event::class);
    }
}
