<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = [
        'country_id',
        'latitude',
        'longitude',
        'temperature',
        'rain',
        'wind_speed',
        'weather_code',
        'storm_risk',
        'retrieved_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'temperature' => 'float',
        'rain' => 'float',
        'wind_speed' => 'float',
        'weather_code' => 'integer',
        'retrieved_at' => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getConditionLabelAttribute(): string
    {
        $code = (int) $this->weather_code;

        return match (true) {
            $code === 0 => 'Clear Sky',

            in_array($code, [1, 2, 3], true)
                => 'Cloudy',

            in_array($code, [45, 48], true)
                => 'Fog',

            in_array($code, [51, 53, 55, 56, 57], true)
                => 'Drizzle',

            in_array($code, [61, 63, 65, 66, 67], true)
                => 'Rain',

            in_array($code, [71, 73, 75, 77], true)
                => 'Snow',

            in_array($code, [80, 81, 82], true)
                => 'Rain Shower',

            in_array($code, [85, 86], true)
                => 'Snow Shower',

            in_array($code, [95, 96, 99], true)
                => 'Thunderstorm',

            default => 'Unknown Weather',
        };
    }

    public function getMonitoringLevelAttribute(): string
    {
        if ($this->storm_risk === 'CRITICAL') {
            return 'CRITICAL';
        }

        if (
            $this->storm_risk === 'HIGH'
            || $this->rain >= 20
            || $this->wind_speed >= 60
        ) {
            return 'CRITICAL';
        }

        if (
            $this->storm_risk === 'MEDIUM'
            || $this->rain >= 10
            || $this->wind_speed >= 40
        ) {
            return 'WARNING';
        }

        return 'NORMAL';
    }
}