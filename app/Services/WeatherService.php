<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Weather;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    public function sync(Country $country): bool
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Coordinate Override
            |--------------------------------------------------------------------------
            | Digunakan jika nama ibu kota sulit ditemukan oleh Geocoding API.
            */

            $coordinateOverrides = [
                'US' => [
                    'latitude' => 38.9072,
                    'longitude' => -77.0369,
                ],
            ];

            /*
            |--------------------------------------------------------------------------
            | Tentukan Latitude dan Longitude
            |--------------------------------------------------------------------------
            */

            if (isset($coordinateOverrides[$country->code])) {

                $latitude = $coordinateOverrides[$country->code]['latitude'];
                $longitude = $coordinateOverrides[$country->code]['longitude'];

            } else {

                /*
                |--------------------------------------------------------------------------
                | Cari koordinat berdasarkan ibu kota
                |--------------------------------------------------------------------------
                */

                $locationName = $country->capital ?: $country->name;

                $locationResponse = Http::timeout(20)
                    ->retry(2, 500)
                    ->get(
                        'https://geocoding-api.open-meteo.com/v1/search',
                        [
                            'name' => $locationName,
                            'count' => 10,
                            'language' => 'en',
                            'format' => 'json',
                        ]
                    );

                if (!$locationResponse->successful()) {

                    Log::warning('Geocoding request failed', [
                        'country' => $country->name,
                    ]);

                    return false;
                }

                $results = $locationResponse->json('results', []);

                if (empty($results)) {

                    Log::warning('Geocoding location not found', [
                        'country' => $country->name,
                        'location' => $locationName,
                    ]);

                    return false;
                }

                /*
                |--------------------------------------------------------------------------
                | Cari berdasarkan Country Code
                |--------------------------------------------------------------------------
                */

                $location = collect($results)
                    ->first(function ($item) use ($country) {

                        return strtoupper($item['country_code'] ?? '')
                            === strtoupper($country->code);

                    });

                /*
                |--------------------------------------------------------------------------
                | Fallback hasil pertama
                |--------------------------------------------------------------------------
                */

                if (!$location) {
                    $location = $results[0];
                }

                $latitude = $location['latitude'] ?? null;
                $longitude = $location['longitude'] ?? null;

                if ($latitude === null || $longitude === null) {

                    Log::warning('Invalid geocoding coordinates', [
                        'country' => $country->name,
                    ]);

                    return false;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil Current Weather dari Open-Meteo
            |--------------------------------------------------------------------------
            */

            $weatherResponse = Http::timeout(20)
                ->retry(2, 500)
                ->get(
                    'https://api.open-meteo.com/v1/forecast',
                    [
                        'latitude' => $latitude,

                        'longitude' => $longitude,

                        'current' => implode(',', [
                            'temperature_2m',
                            'rain',
                            'wind_speed_10m',
                            'weather_code',
                        ]),

                        'timezone' => 'auto',
                    ]
                );

            if (!$weatherResponse->successful()) {

                Log::warning('Weather API request failed', [
                    'country' => $country->name,
                ]);

                return false;
            }

            $current = $weatherResponse->json('current');

            if (!$current) {

                Log::warning('Current weather data unavailable', [
                    'country' => $country->name,
                ]);

                return false;
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan Weather ke Database
            |--------------------------------------------------------------------------
            */

            Weather::updateOrCreate(
                [
                    'country_id' => $country->id,
                ],
                [
                    'temperature' => $current['temperature_2m'] ?? 0,

                    'rain' => $current['rain'] ?? 0,

                    'wind_speed' => $current['wind_speed_10m'] ?? 0,

                    'weather_code' => $current['weather_code'] ?? 0,

                    'retrieved_at' => now(),
                ]
            );

            return true;

        } catch (\Throwable $e) {

            Log::error('Weather sync failed', [
                'country' => $country->name,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Sync Semua Negara
    |--------------------------------------------------------------------------
    */

    public function syncAll(): array
    {
        $success = 0;
        $failed = 0;

        Country::query()
            ->orderBy('id')
            ->chunkById(
                50,
                function ($countries) use (&$success, &$failed) {

                    foreach ($countries as $country) {

                        if ($this->sync($country)) {

                            $success++;

                        } else {

                            $failed++;

                        }
                    }
                }
            );

        return [
            'success' => $success,
            'failed' => $failed,
        ];
    }
}