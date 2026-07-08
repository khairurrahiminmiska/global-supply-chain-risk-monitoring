<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class WorldBankService
{
    public function sync(Country $country)
    {
        // Mapping kode negara ke World Bank (pakai ISO2)
        $countryCode = strtolower($country->code);

        /*
        GDP
        NY.GDP.MKTP.CD

        Inflation
        FP.CPI.TOTL.ZG
        */

        $gdp = $this->getIndicator(
            $countryCode,
            'NY.GDP.MKTP.CD'
        );

        $inflation = $this->getIndicator(
            $countryCode,
            'FP.CPI.TOTL.ZG'
        );

        $country->update([

            'gdp' => $gdp,

            'inflation' => $inflation,

        ]);

        return true;
    }

    private function getIndicator($countryCode, $indicator)
    {
        $url =
            "https://api.worldbank.org/v2/country/{$countryCode}/indicator/{$indicator}?format=json";

        $response = Http::timeout(30)->get($url);

        if (!$response->successful()) {
            return null;
        }

        $json = $response->json();

        if (!isset($json[1])) {
            return null;
        }

        foreach ($json[1] as $item) {

            if (!empty($item['value'])) {

                return $item['value'];

            }

        }

        return null;
    }
}