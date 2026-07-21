<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;

class PortApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Port::with('country');

        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('country_id')) {
            $query->where(
                'country_id',
                $request->country_id
            );
        }

        $ports = $query
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Ports retrieved successfully.',
            'total' => $ports->count(),
            'data' => $ports
        ]);
    }
}