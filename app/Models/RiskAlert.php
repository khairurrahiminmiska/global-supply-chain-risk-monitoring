<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskAlert extends Model
{
    protected $fillable = [
        'country_id',
        'risk_score_id',
        'type',
        'level',
        'title',
        'message',
        'risk_score',
        'is_read',
        'triggered_at',
    ];

    protected $casts = [
        'risk_score' => 'float',
        'is_read' => 'boolean',
        'triggered_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function riskScore(): BelongsTo
    {
        return $this->belongsTo(RiskScore::class);
    }
}
