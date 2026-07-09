<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CountryService
{
    public function syncCountries()
    {
        $response = Http::get(
            'https://restcountries.com/v3.1/all'
        );

        if (!$response->successful()) {
            return;
        }

        $countries = $response->json();

        dd(count($countries));

        $allowed = [

            'Indonesia',
            'Malaysia',
            'Singapore',
            'Thailand',
            'Vietnam',

            'China',
            'Japan',

            'Korea, Republic of',
            'South Korea',

            'India',

            'Australia',
            'New Zealand',

            'Germany',
            'France',
            'Italy',
            'Spain',
            'Netherlands',

            'United Kingdom',

            'United States',
            'United States of America',

            'Canada',
            'Mexico',

            'Brazil',
            'Argentina',

            'Saudi Arabia',

            'United Arab Emirates',

            'South Africa',

        ];

        foreach ($countries as $country) {

            $name = $country['name']['common'] ?? '';

            if (!in_array($name, $allowed)) {
                continue;
            }

            Country::updateOrCreate(

                [

                    'code' => $country['cca2']

                ],

                [

                    'name' => $name,

                    'capital' => $country['capital'][0] ?? '-',

                    'region' => $country['region'] ?? '-',

                    'currency' => array_key_first(
                        $country['currencies'] ?? []
                    ) ?? '-',

                    'population' => $country['population'] ?? 0,

                    'flag' => $country['flags']['png'] ?? '',

                ]

            );

        }
    }
}