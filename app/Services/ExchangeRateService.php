<?php

namespace App\Services;

use App\Models\Country;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    public function sync(Country $country)
    {
        // Pastikan negara memiliki mata uang
        if (!$country->currency) {
            return false;
        }

        $apiKey = env('EXCHANGE_RATE_API_KEY');

        $response = Http::get(
            "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD"
        );

        if (!$response->successful()) {
            return false;
        }

        $json = $response->json();

        // Pastikan data kurs tersedia
        if (!isset($json['conversion_rates'][$country->currency])) {
            return false;
        }

        ExchangeRate::updateOrCreate(

            [
                'country_id' => $country->id,
                'base_currency' => 'USD',
                'target_currency' => $country->currency,
            ],

            [
                'rate' => $json['conversion_rates'][$country->currency],
                'retrieved_at' => now(),
            ]

        );

        return true;
    }
}