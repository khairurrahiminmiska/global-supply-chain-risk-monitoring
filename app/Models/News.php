<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [

    'country_id',

    'title',

    'description',

    'source',

    'url',

    'image',

    'published_at',

    'positive_score',

    'negative_score',

    'sentiment'

];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}