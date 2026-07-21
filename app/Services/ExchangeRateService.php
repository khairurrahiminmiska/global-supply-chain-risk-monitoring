<?php

namespace App\Services;

use App\Models\Country;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    public function sync(Country $country): bool
    {
        try {

            if (!$country->currency) {
                return false;
            }

            $apiKey = env('EXCHANGE_RATE_API_KEY');

            if (!$apiKey) {

                Log::warning('Exchange Rate API key not found');

                return false;
            }

            $response = Http::timeout(20)
                ->retry(2, 500)
                ->get(
                    "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD"
                );

            if (!$response->successful()) {

                Log::warning('Exchange Rate API request failed', [
                    'country' => $country->name,
                ]);

                return false;
            }

            $json = $response->json();

            $rate = $json['conversion_rates'][$country->currency]
                ?? null;

            if ($rate === null) {

                Log::warning('Currency rate not found', [
                    'country' => $country->name,
                    'currency' => $country->currency,
                ]);

                return false;
            }

            ExchangeRate::updateOrCreate(
                [
                    'country_id' => $country->id,
                    'base_currency' => 'USD',
                    'target_currency' => $country->currency,
                ],
                [
                    'rate' => $rate,
                    'retrieved_at' => now(),
                ]
            );

            return true;

        } catch (\Throwable $e) {

            Log::error('Exchange Rate sync failed', [
                'country' => $country->name,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

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