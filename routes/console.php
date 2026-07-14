<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Global Supply Chain Risk Monitoring Scheduler
|--------------------------------------------------------------------------
|
| Automatically recalculates country risk scores.
|
| Process:
| Country Data
| → Risk Scoring
| → Risk History
| → Risk Alerts
|
*/

Schedule::command('risk:monitor')
    ->hourly()
    ->withoutOverlapping()
    ->onOneServer()
    ->appendOutputTo(
        storage_path('logs/risk-monitoring.log')
    );