<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\News;

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
}