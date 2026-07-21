<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\Country;
use Illuminate\Http\Request;

class PortDashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY FILTER TABLE
        |--------------------------------------------------------------------------
        */

        $query = Port::with('country');

        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('country')) {
            $query->where(
                'country_id',
                $request->country
            );
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE PORTS
        |--------------------------------------------------------------------------
        */

        $ports = $query
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | SEMUA PORT UNTUK MAP
        |--------------------------------------------------------------------------
        */

        $mapPorts = Port::with('country')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TARGET PORT UNTUK AUTO ZOOM
        |--------------------------------------------------------------------------
        */

        $targetPorts = collect();

        if (
            $request->filled('search') ||
            $request->filled('country')
        ) {
            $targetQuery = Port::with('country');

            if ($request->filled('search')) {
                $targetQuery->where(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                );
            }

            if ($request->filled('country')) {
                $targetQuery->where(
                    'country_id',
                    $request->country
                );
            }

            $targetPorts = $targetQuery
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | COUNTRIES
        |--------------------------------------------------------------------------
        */

        $countries = Country::orderBy('name')->get();

        return view('ports.index', compact(
            'ports',
            'countries',
            'mapPorts',
            'targetPorts'
        ));
    }
}