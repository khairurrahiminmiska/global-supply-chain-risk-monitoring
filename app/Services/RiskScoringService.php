<?php

namespace App\Services;

use App\Models\Country;
use App\Models\RiskScore;
use App\Models\RiskHistory;

class RiskScoringService
{
    public function calculateAll(): void
    {
        Country::query()
            ->withCount('ports')
            ->chunkById(100, function ($countries) {

                foreach ($countries as $country) {
                    $this->calculate($country);
                }

            });
    }

    public function calculate(Country $country): RiskScore
    {
        $weatherScore = $this->calculateWeatherScore($country);

        $inflationScore = $this->calculateInflationScore($country);

        $currencyScore = $this->calculateCurrencyScore($country);

        $newsScore = $this->calculateNewsScore($country);

        $portScore = $this->calculatePortScore($country);

        /*
        |--------------------------------------------------------------------------
        | Weighted Risk Score
        |--------------------------------------------------------------------------
        |
        | Weather   = 20%
        | Inflation = 25%
        | Currency  = 20%
        | News      = 20%
        | Port      = 15%
        |
        */

        $totalScore = (int) round(
            ($weatherScore * 0.20) +
            ($inflationScore * 0.25) +
            ($currencyScore * 0.20) +
            ($newsScore * 0.20) +
            ($portScore * 0.15)
        );

        $riskLevel = match (true) {
            $totalScore >= 70 => 'HIGH',
            $totalScore >= 40 => 'MEDIUM',
            default => 'LOW',
        };

        $riskScore = RiskScore::updateOrCreate(
    [
        'country_id' => $country->id,
    ],
    [
        'weather_score' => $weatherScore,
        'inflation_score' => $inflationScore,
        'currency_score' => $currencyScore,
        'news_score' => $newsScore,
        'port_score' => $portScore,
        'total_score' => $totalScore,
        'risk_level' => $riskLevel,
        'calculated_at' => now(),
    ]
);

RiskHistory::create([
    'country_id' => $country->id,
    'weather_score' => $weatherScore,
    'inflation_score' => $inflationScore,
    'currency_score' => $currencyScore,
    'news_score' => $newsScore,
    'port_score' => $portScore,
    'total_score' => $totalScore,
    'risk_level' => $riskLevel,
    'calculated_at' => now(),
]);

return $riskScore;
    }

    /*
    |--------------------------------------------------------------------------
    | Weather Risk
    |--------------------------------------------------------------------------
    */

    private function calculateWeatherScore(Country $country): int
    {
        $weather = $country->weather()
            ->latest('retrieved_at')
            ->first();

        if (!$weather) {
            return 50;
        }

        $score = 0;

        $rain = (float) $weather->rain;

        $wind = (float) $weather->wind_speed;

        /*
        | Rain Risk
        */

        $score += match (true) {
            $rain >= 20 => 50,
            $rain >= 10 => 40,
            $rain >= 5 => 30,
            $rain > 0 => 15,
            default => 0,
        };

        /*
        | Wind Risk
        */

        $score += match (true) {
            $wind >= 80 => 50,
            $wind >= 60 => 40,
            $wind >= 40 => 30,
            $wind >= 20 => 15,
            default => 0,
        };

        return min($score, 100);
    }

    /*
    |--------------------------------------------------------------------------
    | Inflation Risk
    |--------------------------------------------------------------------------
    */

    private function calculateInflationScore(Country $country): int
    {
        $inflation = (float) ($country->inflation ?? 0);

        return match (true) {
            $inflation >= 15 => 100,
            $inflation >= 10 => 80,
            $inflation >= 5 => 60,
            $inflation >= 2 => 30,
            default => 10,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Currency Risk
    |--------------------------------------------------------------------------
    */

    private function calculateCurrencyScore(Country $country): int
    {
        $exchangeRate = $country->exchangeRates()
            ->latest('retrieved_at')
            ->first();

        if (!$exchangeRate) {
            return 50;
        }

        $rate = (float) $exchangeRate->rate;

        /*
        |--------------------------------------------------------------------------
        | Currency Exposure Score
        |--------------------------------------------------------------------------
        |
        | Ini mengukur exposure nilai mata uang terhadap USD.
        |
        */

        return match (true) {
            $rate >= 10000 => 80,
            $rate >= 1000 => 70,
            $rate >= 100 => 60,
            $rate >= 10 => 40,
            $rate >= 2 => 20,
            default => 10,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | News Sentiment Risk
    |--------------------------------------------------------------------------
    */

    private function calculateNewsScore(Country $country): int
    {
        $news = $country->news()
            ->latest('published_at')
            ->limit(20)
            ->get();

        if ($news->isEmpty()) {
            return 50;
        }

        $negative = $news
            ->where('sentiment', 'negative')
            ->count();

        $total = $news->count();

        $negativePercentage = ($negative / $total) * 100;

        return match (true) {
            $negativePercentage >= 80 => 100,
            $negativePercentage >= 60 => 80,
            $negativePercentage >= 40 => 60,
            $negativePercentage >= 20 => 40,
            default => 10,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Port Infrastructure Risk
    |--------------------------------------------------------------------------
    */

    private function calculatePortScore(Country $country): int
    {
        $portCount = $country->ports_count
            ?? $country->ports()->count();

        return match (true) {
            $portCount === 0 => 100,
            $portCount <= 2 => 80,
            $portCount <= 5 => 60,
            $portCount <= 10 => 40,
            $portCount <= 20 => 20,
            default => 10,
        };
    }
}