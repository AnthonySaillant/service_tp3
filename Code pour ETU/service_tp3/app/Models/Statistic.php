<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = [
        'average_score',
        'nb_votes',
        'film_id'
    ];

    public function film() 
    {
        return $this->belongsTo('App\Models\Film');
    }
}
