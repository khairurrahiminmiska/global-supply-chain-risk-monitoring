<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\RiskScore;
use App\Models\ExchangeRate;

class BusinessDashboardController extends Controller
{
    public function index()
{
    $countries = Country::orderBy('name')->get();

    $riskScores = RiskScore::with('country')
        ->orderBy('total_score', 'desc')
        ->get();

    $exchangeRates = ExchangeRate::with('country')
        ->latest()
        ->get();

    $chartData = [

        'countries' => $countries->pluck('name'),

        'gdp' => $countries->pluck('gdp'),

        'inflation' => $countries->pluck('inflation'),

        'currency' => $exchangeRates
            ->sortBy('country.name')
            ->pluck('rate'),

        'risk' => $riskScores
            ->sortBy('country.name')
            ->pluck('total_score'),

    ];

    return view(
        'business.index',
        compact(
            'countries',
            'riskScores',
            'exchangeRates',
            'chartData'
        )
    );
}
}
