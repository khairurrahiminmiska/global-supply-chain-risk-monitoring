<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class Port extends Model
{
    protected $fillable = [

        'country_id',

        'country_code',

        'wpi_number',

        'name',

        'harbor_size',

        'harbor_type',

        'latitude',

        'longitude',

        'status'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}