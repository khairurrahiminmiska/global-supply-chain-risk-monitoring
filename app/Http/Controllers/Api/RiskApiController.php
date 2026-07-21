<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiskScore;
use Illuminate\Http\Request;

class RiskApiController extends Controller
{
    public function index(Request $request)
    {
        $query = RiskScore::query()
            ->with('country');

        if ($request->filled('country_id')) {
            $query->where(
                'country_id',
                $request->integer('country_id')
            );
        }

        if ($request->filled('level')) {
            $query->where(
                'risk_level',
                strtoupper($request->level)
            );
        }

        $riskScores = $query
            ->orderByDesc('total_score')
            ->get();

        $risks = $riskScores->map(function (RiskScore $risk) {
            return [
                'country_id' => $risk->country_id,

                'country' => $risk->country?->name ?? 'Unknown',

                'risk_score' => $risk->total_score,

                'risk_level' => $risk->risk_level,

                'indicators' => [
                    'weather_score' => $risk->weather_score,
                    'inflation_score' => $risk->inflation_score,
                    'currency_score' => $risk->currency_score,
                    'news_score' => $risk->news_score,
                    'port_score' => $risk->port_score,
                ],

                'calculated_at' => $risk->calculated_at,
            ];
        });

        return response()->json([
            'success' => true,

            'message' => 'Supply chain risk data retrieved successfully.',

            'total' => $risks->count(),

            'data' => $risks,
        ]);
    }
}
