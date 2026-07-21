<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\News;
use App\Models\RiskScore;
use App\Models\RiskHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $countryCount = Country::count();

        $exchangeRateCount = ExchangeRate::count();

        $newsCount = News::count();

        $latestCountries = Country::latest()
            ->take(5)
            ->get();

        $latestNews = News::latest('published_at')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Risk Statistics
        |--------------------------------------------------------------------------
        */

        $averageRiskScore = round(
            RiskScore::avg('total_score') ?? 0,
            1
        );

        $highRiskCount = RiskScore::where(
            'risk_level',
            'HIGH'
        )->count();

        $mediumRiskCount = RiskScore::where(
            'risk_level',
            'MEDIUM'
        )->count();

        $lowRiskCount = RiskScore::where(
            'risk_level',
            'LOW'
        )->count();

        $globalRiskLevel = match (true) {
            $averageRiskScore >= 70 => 'HIGH',
            $averageRiskScore >= 40 => 'MEDIUM',
            default => 'LOW',
        };

        return view('dashboard', compact(
            'countryCount',
            'exchangeRateCount',
            'newsCount',
            'latestCountries',
            'latestNews',
            'averageRiskScore',
            'highRiskCount',
            'mediumRiskCount',
            'lowRiskCount',
            'globalRiskLevel'
        ));
    }


    public function chartData()
{
    $countries = Country::orderBy('name')->get();

    $riskHistories = RiskHistory::query()
        ->selectRaw("
            DATE_FORMAT(calculated_at, '%Y-%m-%d %H:%i:%s') as period,
            AVG(total_score) as average_score
        ")
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    return response()->json([

        'labels' => $countries->pluck('name'),

        'gdp' => $countries->pluck('gdp'),

        'inflation' => $countries->pluck('inflation'),

        'currency' => $countries->map(function ($country) {

            return ExchangeRate::where(
                'country_id',
                $country->id
            )
                ->latest('retrieved_at')
                ->value('rate') ?? 0;

        }),

        'risk_labels' => $riskHistories->map(function ($history) {
            return \Carbon\Carbon::parse($history->period)
                ->format('d M H:i:s');
        }),

        'risk' => $riskHistories->map(function ($history) {
            return round((float) $history->average_score, 2);
        }),

    ]);
}
}