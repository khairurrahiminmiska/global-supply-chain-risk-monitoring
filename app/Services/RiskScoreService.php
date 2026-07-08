<?php

namespace App\Services;

use App\Models\Country;
use App\Models\RiskScore;

class RiskScoreService
{
    public function calculate(Country $country)
    {
        /*
        |--------------------------------------------------------------------------
        | WEATHER SCORE (30%)
        |--------------------------------------------------------------------------
        */

        $weather = $country->weather;

        $weatherScore = 0;

        if ($weather) {

            if ($weather->wind_speed >= 30)
                $weatherScore += 30;

            elseif ($weather->wind_speed >= 20)
                $weatherScore += 20;

            elseif ($weather->wind_speed >= 10)
                $weatherScore += 10;

            if ($weather->rain >= 20)
                $weatherScore += 20;

        }

        /*
        |--------------------------------------------------------------------------
        | INFLATION SCORE (20%)
        |--------------------------------------------------------------------------
        */

        $inflationScore = 0;

        if ($country->inflation >= 10)
            $inflationScore = 20;

        elseif ($country->inflation >= 5)
            $inflationScore = 10;

        /*
        |--------------------------------------------------------------------------
        | CURRENCY SCORE (10%)
        |--------------------------------------------------------------------------
        */

        $currency = $country->exchangeRates()->latest()->first();

        $currencyScore = $currency ? 10 : 0;

        /*
        |--------------------------------------------------------------------------
        | NEWS SCORE (40%)
        |--------------------------------------------------------------------------
        */

        $newsCount = $country->news()->count();

        if ($newsCount >= 10)
            $newsScore = 40;

        elseif ($newsCount >= 5)
            $newsScore = 20;

        else
            $newsScore = 10;

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $total =

            $weatherScore +

            $inflationScore +

            $currencyScore +

            $newsScore;

        if ($total >= 70)

            $level = 'HIGH';

        elseif ($total >= 40)

            $level = 'MEDIUM';

        else

            $level = 'LOW';

        RiskScore::updateOrCreate(

            [

                'country_id' => $country->id

            ],

            [

                'weather_score' => $weatherScore,

                'inflation_score' => $inflationScore,

                'currency_score' => $currencyScore,

                'news_score' => $newsScore,

                'total_score' => $total,

                'risk_level' => $level,

                'calculated_at' => now(),

            ]

        );
    }
}