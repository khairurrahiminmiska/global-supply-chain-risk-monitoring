<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;
use Illuminate\Http\Request;
use App\Models\RiskHistory;

class RiskScoreController extends Controller
{
    public function index(Request $request)
    {
        $query = RiskScore::with('country');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('country', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('level')) {
            $query->where('risk_level', $request->level);
        }

        $riskScores = $query
            ->orderByDesc('total_score')
            ->paginate(10)
            ->withQueryString();

        $totalCountries = RiskScore::count();

        $lowRisk = RiskScore::where('risk_level', 'LOW')->count();

        $mediumRisk = RiskScore::where('risk_level', 'MEDIUM')->count();

        $highRisk = RiskScore::where('risk_level', 'HIGH')->count();

        return view('risk.index', compact(
            'riskScores',
            'totalCountries',
            'lowRisk',
            'mediumRisk',
            'highRisk'
        ));
    }

    public function show(RiskScore $riskScore)
{
    $riskScore->load('country');

    $riskHistories = \App\Models\RiskHistory::where(
        'country_id',
        $riskScore->country_id
    )
        ->orderBy('calculated_at')
        ->get();

    $chartLabels = $riskHistories
        ->map(function ($history) {
            return $history->calculated_at
                ? $history->calculated_at->format('d M H:i:s')
                : '-';
        });

    $chartScores = $riskHistories
        ->pluck('total_score');

    return view('risk.show', compact(
        'riskScore',
        'riskHistories',
        'chartLabels',
        'chartScores'
    ));
}
}
