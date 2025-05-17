<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Film extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'title', 
        'release_year',
        'length',
        'description',
        'rating',
        'language_id',
        'special_features',
        'image'
    ];

    public function language() 
    {
        return $this->belongsTo('App\Models\Language');
    }


    public function critics() 
    {
        return $this->hasMany('App\Models\Critic');
    }

    public function statistic()
    {
        return $this->hasOne('App\Models\Statistic');
    }
    
    public function actors() 
    {
        return $this->belongsToMany('App\Models\Actor');
    }
    

    /*
        chat GPT pour getRatingAttribute et setRatingAttribute pas le choix de converir le - en _ car lighthouse a un probleme avec les _ 
    */

    // Accessor : pour transformer - en _ à la lecture
    public function getRatingAttribute($value)
    {
        return str_replace('-', '_', $value);
    }

    // Mutator : pour transformer _ en - à l’écriture
    public function setRatingAttribute($value)
    {
        $this->attributes['rating'] = str_replace('_', '-', $value);
    }
}
