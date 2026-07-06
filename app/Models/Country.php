<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'capital',
        'region',
        'currency',
        'population',
        'flag',
    ];

    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class);
    }
}