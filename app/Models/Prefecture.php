<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    use HasFactory;

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }
}
