<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryApiController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'message' => 'Countries retrieved successfully.',
            'total' => $countries->count(),
            'data' => $countries
        ]);
    }
}