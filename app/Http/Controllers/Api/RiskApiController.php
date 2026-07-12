<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class RiskApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::query();

        if ($request->filled('country_id')) {
            $query->where('id', $request->country_id);
        }

        $countries = $query->get();

        $risks = $countries->map(function ($country) {

            $inflation = (float) ($country->inflation ?? 0);

            $score = 0;

            if ($inflation >= 10) {
                $score += 70;
            } elseif ($inflation >= 5) {
                $score += 40;
            } else {
                $score += 20;
            }

            if ($score >= 70) {
                $level = 'HIGH';
            } elseif ($score >= 40) {
                $level = 'MEDIUM';
            } else {
                $level = 'LOW';
            }

            return [
                'country_id' => $country->id,
                'country' => $country->name,
                'risk_score' => $score,
                'risk_level' => $level,
                'indicators' => [
                    'inflation' => $inflation,
                ],
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
