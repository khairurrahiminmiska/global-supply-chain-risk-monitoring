<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Weather;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function sync(Country $country)
    {
        /*
        |------------------------------------------------------------
        | Mapping Latitude & Longitude
        |------------------------------------------------------------
        | Karena REST Countries belum menyimpan koordinat,
        | sementara kita buat mapping manual.
        | Nanti bisa kita upgrade otomatis dari REST Countries API.
        */

        $locations = [

            'ID' => [
                'lat' => -6.2088,
                'lon' => 106.8456
            ],

            'JP' => [
                'lat' => 35.6762,
                'lon' => 139.6503
            ],

            'DE' => [
                'lat' => 52.5200,
                'lon' => 13.4050
            ],

            'CN' => [
                'lat' => 39.9042,
                'lon' => 116.4074
            ],

            'AU' => [
                'lat' => -35.2809,
                'lon' => 149.1300
            ],

        ];

        if (!isset($locations[$country->code])) {
            return false;
        }

        $lat = $locations[$country->code]['lat'];
        $lon = $locations[$country->code]['lon'];

        $response = Http::get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude' => $lat,
                'longitude' => $lon,

                'current' =>

                    'temperature_2m,' .
                    'rain,' .
                    'wind_speed_10m,' .
                    'weather_code',

                'timezone' => 'auto'
            ]
        );

        if (!$response->successful()) {
            return false;
        }

        $current = $response->json()['current'];

        Weather::updateOrCreate(

            [
                'country_id' => $country->id
            ],

            [

                'temperature' => $current['temperature_2m'],

                'rain' => $current['rain'],

                'wind_speed' => $current['wind_speed_10m'],

                'weather_code' => $current['weather_code'],

                'retrieved_at' => now()

            ]

        );

        return true;
    }
}