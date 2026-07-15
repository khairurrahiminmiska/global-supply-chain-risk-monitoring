<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Weather;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherMonitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Weather::query()
            ->with('country');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('country', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('capital', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('condition')) {
            match ($request->condition) {
                'CRITICAL' => $query->where(function ($q) {
                    $q->where('storm_risk', 'CRITICAL')
                        ->orWhere('storm_risk', 'HIGH')
                        ->orWhere('rain', '>=', 20)
                        ->orWhere('wind_speed', '>=', 60)
                        ->orWhere('temperature', '>=', 40)
                        ->orWhere('temperature', '<=', -10);
                }),

                'WARNING' => $query->where(function ($q) {
                    $q->where('storm_risk', 'MEDIUM')
                        ->orWhereBetween('rain', [10, 19.99])
                        ->orWhereBetween('wind_speed', [40, 59.99])
                        ->orWhereBetween('temperature', [35, 39.99])
                        ->orWhereBetween('temperature', [-9.99, 0]);
                }),

                default => null,
            };
        }

        $weatherRecords = $query
            ->orderByDesc('retrieved_at')
            ->paginate(12)
            ->withQueryString();

        $allWeather = Weather::query()
            ->with('country')
            ->get();

        $totalCountries = Country::query()->count();

        $monitoredCountries = $allWeather->count();

        $criticalWeather = $allWeather
            ->filter(
                fn ($weather) =>
                $this->getRiskLevel($weather) === 'CRITICAL'
            )
            ->count();

        $warningWeather = $allWeather
            ->filter(
                fn ($weather) =>
                $this->getRiskLevel($weather) === 'WARNING'
            )
            ->count();

        $averageTemperature = $allWeather->isNotEmpty()
            ? round($allWeather->avg('temperature'), 1)
            : 0;

        $stormRiskSummary = [
            'LOW' => $allWeather
                ->where('storm_risk', 'LOW')
                ->count(),

            'MEDIUM' => $allWeather
                ->where('storm_risk', 'MEDIUM')
                ->count(),

            'HIGH' => $allWeather
                ->where('storm_risk', 'HIGH')
                ->count(),

            'CRITICAL' => $allWeather
                ->where('storm_risk', 'CRITICAL')
                ->count(),
        ];

        $weatherRecords
            ->getCollection()
            ->transform(function ($weather) {
                $weather->monitoring_level =
                    $this->getRiskLevel($weather);

                $weather->condition_label =
                    $this->getWeatherCondition(
                        $weather->weather_code
                    );

                return $weather;
            });

        return view('weather.index', compact(
            'weatherRecords',
            'totalCountries',
            'monitoredCountries',
            'criticalWeather',
            'warningWeather',
            'averageTemperature',
            'stormRiskSummary'
        ));
    }

    public function sync(
        WeatherService $weatherService
    ) {
        $result = $weatherService->syncAll();

        return redirect()
            ->route('weather.index')
            ->with(
                'success',
                "Weather monitoring updated. "
                . "{$result['success']} countries synchronized "
                . "and {$result['failed']} failed."
            );
    }

    private function getRiskLevel(
        Weather $weather
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Critical Weather
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $weather->storm_risk,
                ['HIGH', 'CRITICAL'],
                true
            )
            || $weather->rain >= 20
            || $weather->wind_speed >= 60
            || $weather->temperature >= 40
            || $weather->temperature <= -10
        ) {
            return 'CRITICAL';
        }

        /*
        |--------------------------------------------------------------------------
        | Weather Warning
        |--------------------------------------------------------------------------
        */

        if (
            $weather->storm_risk === 'MEDIUM'
            || $weather->rain >= 10
            || $weather->wind_speed >= 40
            || $weather->temperature >= 35
            || $weather->temperature <= 0
        ) {
            return 'WARNING';
        }

        return 'NORMAL';
    }

    private function getWeatherCondition(
        ?string $code
    ): string {
        $code = (int) $code;

        return match (true) {
            $code === 0
                => 'Clear Sky',

            in_array($code, [1, 2, 3], true)
                => 'Cloudy',

            in_array($code, [45, 48], true)
                => 'Fog',

            in_array(
                $code,
                [51, 53, 55, 56, 57],
                true
            )
                => 'Drizzle',

            in_array(
                $code,
                [61, 63, 65, 66, 67],
                true
            )
                => 'Rain',

            in_array(
                $code,
                [71, 73, 75, 77],
                true
            )
                => 'Snow',

            in_array($code, [80, 81, 82], true)
                => 'Rain Shower',

            in_array($code, [85, 86], true)
                => 'Snow Shower',

            in_array($code, [95, 96, 99], true)
                => 'Thunderstorm',

            default
                => 'Unknown',
        };
    }
}