<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'image_path',
        'prefecture',
        'region',
        'population',
        'investigated_at',
    ];

    public function prefecture()
    {
        return $this->belongsTo('App\Models\Prefecture');
    }
}
