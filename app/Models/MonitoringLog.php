<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringLog extends Model
{
    protected $fillable = [
        'type',
        'status',
        'total_countries',
        'success_count',
        'failed_count',
        'started_at',
        'completed_at',
        'duration_ms',
        'message',
    ];

    protected $casts = [
        'total_countries' => 'integer',
        'success_count' => 'integer',
        'failed_count' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'duration_ms' => 'integer',
    ];
}
