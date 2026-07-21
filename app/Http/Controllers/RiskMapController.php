<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;

class RiskMapController extends Controller
{
    public function index()
    {
        $riskScores = RiskScore::query()
            ->with([
                'country.ports',
            ])
            ->orderByDesc('total_score')
            ->get();

        $riskMapData = $riskScores
            ->filter(function ($risk) {
                return $risk->country
                    && $risk->country->ports->isNotEmpty();
            })
            ->map(function ($risk) {

                $country = $risk->country;

                $validPorts = $country->ports
                    ->filter(function ($port) {
                        return is_numeric($port->latitude)
                            && is_numeric($port->longitude);
                    });

                if ($validPorts->isEmpty()) {
                    return null;
                }

                /*
                |--------------------------------------------------------------------------
                | Country Supply Chain Center
                |--------------------------------------------------------------------------
                |
                | Titik negara dihitung berdasarkan rata-rata koordinat
                | pelabuhan yang tersedia.
                |
                */

                $latitude = $validPorts->avg(function ($port) {
                    return (float) $port->latitude;
                });

                $longitude = $validPorts->avg(function ($port) {
                    return (float) $port->longitude;
                });

                $indicators = [
                    'Weather' => (int) $risk->weather_score,
                    'Inflation' => (int) $risk->inflation_score,
                    'Currency' => (int) $risk->currency_score,
                    'News' => (int) $risk->news_score,
                    'Port Infrastructure' => (int) $risk->port_score,
                ];

                $mainIndicator = collect($indicators)
                    ->sortDesc()
                    ->keys()
                    ->first();

                return [
                    'id' => $risk->id,

                    'country_id' => $country->id,

                    'country' => $country->name,

                    'code' => strtoupper($country->code),

                    'capital' => $country->capital,

                    'region' => $country->region,

                    'flag' => $country->flag,

                    'latitude' => round($latitude, 6),

                    'longitude' => round($longitude, 6),

                    'port_count' => $validPorts->count(),

                    'total_score' => (int) $risk->total_score,

                    'risk_level' => $risk->risk_level,

                    'main_indicator' => $mainIndicator,

                    'main_indicator_score' => $indicators[$mainIndicator],

                    'weather_score' => (int) $risk->weather_score,

                    'inflation_score' => (int) $risk->inflation_score,

                    'currency_score' => (int) $risk->currency_score,

                    'news_score' => (int) $risk->news_score,

                    'port_score' => (int) $risk->port_score,

                    'detail_url' => route('risk.show', $risk),
                ];

            })
            ->filter()
            ->values();

        $summary = [
            'total' => $riskMapData->count(),

            'low' => $riskMapData
                ->where('risk_level', 'LOW')
                ->count(),

            'medium' => $riskMapData
                ->where('risk_level', 'MEDIUM')
                ->count(),

            'high' => $riskMapData
                ->where('risk_level', 'HIGH')
                ->count(),
        ];

        return view('risk.map', compact(
            'riskMapData',
            'summary'
        ));
    }
}
