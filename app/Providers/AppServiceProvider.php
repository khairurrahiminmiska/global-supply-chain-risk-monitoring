<?php

namespace App\Providers;

use App\Models\RiskAlert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.main', function ($view) {
            $unreadRiskAlerts = RiskAlert::where('is_read', false)->count();

            $view->with('unreadRiskAlerts', $unreadRiskAlerts);
        });
    }
}
