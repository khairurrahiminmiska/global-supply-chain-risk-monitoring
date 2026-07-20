<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $countryA = null;
        $countryB = null;

        if ($request->country_a) {
            $countryA = Country::with([
                'weather',
                'riskScore',
                'exchangeRates'
            ])->find($request->country_a);
        }

        if ($request->country_b) {
            $countryB = Country::with([
                'weather',
                'riskScore',
                'exchangeRates'
            ])->find($request->country_b);
        }

        return view('comparison.index', compact(
            'countries',
            'countryA',
            'countryB'
        ));
    }

    public function compare(Request $request)
    {
        return $this->index($request);
    }
}