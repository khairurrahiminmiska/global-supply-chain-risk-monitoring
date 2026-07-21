<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class CurrencyApiController extends Controller
{
    public function index(Request $request)
    {
        $query = ExchangeRate::query();

        if ($request->filled('currency')) {
            $query->where(
                'currency',
                'like',
                '%' . $request->currency . '%'
            );
        }

        $rates = $query
            ->latest('updated_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Currency data retrieved successfully.',
            'total' => $rates->count(),
            'data' => $rates,
        ]);
    }
}