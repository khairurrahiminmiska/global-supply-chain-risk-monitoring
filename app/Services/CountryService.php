<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CountryService
{
    /**
     * Mengambil data negara dari REST Countries API
     * lalu menyimpannya ke database.
     */
    public function syncCountries()
    {
        $response = Http::timeout(30)->get(
            'https://restcountries.com/v3.1/all?fields=name,cca2,capital,region,currencies,population,flags'
        );

        if (!$response->successful()) {
            dd($response->status(), $response->body());
        }

        $countries = $response->json();

        foreach ($countries as $country) {

            // Lewati jika tidak memiliki kode negara
            if (empty($country['cca2'])) {
                continue;
            }

            Country::updateOrCreate(
                [
                    'code' => $country['cca2'],
                ],
                [
                    'name'       => $country['name']['common'] ?? '',
                    'capital'    => $country['capital'][0] ?? '',
                    'region'     => $country['region'] ?? '',
                    'currency'   => isset($country['currencies'])
                        ? implode(', ', array_keys($country['currencies']))
                        : '',
                    'population' => $country['population'] ?? 0,
                    'flag'       => $country['flags']['png'] ?? '',
                ]
            );
        }

        return true;
    }
}