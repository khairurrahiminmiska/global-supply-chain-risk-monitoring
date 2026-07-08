<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = [
        'country_id',
        'temperature',
        'rain',
        'wind_speed',
        'weather_code',
        'retrieved_at',
    ];

    protected $casts = [
        'retrieved_at' => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}