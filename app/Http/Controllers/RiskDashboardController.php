<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;

class RiskDashboardController extends Controller
{
    public function index()
    {
        $risks = RiskScore::with('country')
            ->whereHas('country')
            ->orderByDesc('total_score')
            ->get();

        $highRisk = $risks
            ->where('risk_level', 'HIGH')
            ->count();

        $mediumRisk = $risks
            ->where('risk_level', 'MEDIUM')
            ->count();

        $lowRisk = $risks
            ->where('risk_level', 'LOW')
            ->count();

        $averageScore = $risks->isNotEmpty()
            ? round($risks->avg('total_score'), 1)
            : 0;

        $highestRisk = $risks->first();

        $chartCountries = $risks
            ->map(fn ($risk) => $risk->country?->name ?? 'Unknown')
            ->values();

        $chartScores = $risks
            ->pluck('total_score')
            ->values();

        return view('risk.analytics', [
            'risks' => $risks,
            'highRisk' => $highRisk,
            'mediumRisk' => $mediumRisk,
            'lowRisk' => $lowRisk,
            'averageScore' => $averageScore,
            'highestRisk' => $highestRisk,
            'chartCountries' => $chartCountries,
            'chartScores' => $chartScores,
        ]);
    }
}
