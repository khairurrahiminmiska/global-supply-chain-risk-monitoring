<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\News;
use App\Models\RiskScore;

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

        return response()->json([

            'labels' => $countries->pluck('name'),

            'gdp' => $countries->pluck('gdp'),

            'inflation' => $countries->pluck('inflation'),

            'currency' => $countries->map(function ($country) {

                return ExchangeRate::where(
                    'country_id',
                    $country->id
                )
                    ->latest()
                    ->value('rate') ?? 0;

            }),

            'risk' => $countries->map(function ($country) {

                return RiskScore::where(
                    'country_id',
                    $country->id
                )
                    ->latest()
                    ->value('total_score') ?? 0;

            }),

        ]);
    }
}