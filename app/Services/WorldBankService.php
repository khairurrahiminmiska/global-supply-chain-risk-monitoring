<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WorldBankService
{
    public function sync(Country $country)
    {
        $countryCode = strtolower($country->code);

        $gdp = $this->getIndicator(
            $countryCode,
            'NY.GDP.MKTP.CD'
        );

        $inflation = $this->getIndicator(
            $countryCode,
            'FP.CPI.TOTL.ZG'
        );

        $exports = $this->getIndicator(
            $countryCode,
            'NE.EXP.GNFS.CD'
        );

        $imports = $this->getIndicator(
            $countryCode,
            'NE.IMP.GNFS.CD'
        );

        $population = $this->getIndicator(
            $countryCode,
            'SP.POP.TOTL'
        );

        $country->update([
            'gdp' => $gdp,
            'inflation' => $inflation,
            'exports' => $exports,
            'imports' => $imports,
            'population' => $population,
        ]);

        return true;
    }

    private function getIndicator($countryCode, $indicator)
    {
        try {

            $url =
                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/{$indicator}?format=json";

            $response = Http::timeout(15)
                ->retry(3, 1000)
                ->get($url);

            if (! $response->successful()) {
                return null;
            }

            $json = $response->json();

            if (! isset($json[1])) {
                return null;
            }

            foreach ($json[1] as $item) {

                if (! empty($item['value'])) {

                    return $item['value'];

                }

            }

            return null;

        } catch (\Throwable $e) {

            Log::warning('WorldBank indicator failed', [
                'country' => $countryCode,
                'indicator' => $indicator,
                'error' => $e->getMessage(),
            ]);

            return null;

        }
    }
}
