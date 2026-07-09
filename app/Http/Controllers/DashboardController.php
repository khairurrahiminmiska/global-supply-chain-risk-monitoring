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

        return view('dashboard', compact(
            'countryCount',
            'exchangeRateCount',
            'newsCount',
            'latestCountries',
            'latestNews'
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

            return ExchangeRate::where('country_id', $country->id)
                ->latest()
                ->value('rate') ?? 0;

        }),

        'risk' => $countries->map(function ($country) {

            return RiskScore::where('country_id', $country->id)
                ->latest()
                ->value('total_score') ?? 0;

        })

    ]);
}
}