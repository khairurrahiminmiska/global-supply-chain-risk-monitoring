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
        'gdp',

'inflation',

'exports',

'imports',
    ];

    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class);
    }

    public function news()
{
    return $this->hasMany(News::class);
}

    public function weather()
{
    return $this->hasOne(Weather::class);
}

    public function ports()
{
    return $this->hasMany(Port::class);
}

    public function riskScore()
{
    return $this->hasOne(RiskScore::class);
}
}