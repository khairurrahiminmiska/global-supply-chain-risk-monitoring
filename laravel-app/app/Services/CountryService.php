<?php

namespace App\Services;

use App\Models\Country;

class CountryService
{
    public function syncCountries()
    {
        $countries = [
            ['code' => 'ID', 'name' => 'Indonesia', 'capital' => 'Jakarta', 'region' => 'Asia', 'currency' => 'IDR', 'population' => 273523615],
            ['code' => 'MY', 'name' => 'Malaysia', 'capital' => 'Kuala Lumpur', 'region' => 'Asia', 'currency' => 'MYR', 'population' => 32365999],
            ['code' => 'SG', 'name' => 'Singapore', 'capital' => 'Singapore', 'region' => 'Asia', 'currency' => 'SGD', 'population' => 5685807],
            ['code' => 'TH', 'name' => 'Thailand', 'capital' => 'Bangkok', 'region' => 'Asia', 'currency' => 'THB', 'population' => 69799978],
            ['code' => 'VN', 'name' => 'Vietnam', 'capital' => 'Hanoi', 'region' => 'Asia', 'currency' => 'VND', 'population' => 97338579],
            ['code' => 'CN', 'name' => 'China', 'capital' => 'Beijing', 'region' => 'Asia', 'currency' => 'CNY', 'population' => 1402112000],
            ['code' => 'JP', 'name' => 'Japan', 'capital' => 'Tokyo', 'region' => 'Asia', 'currency' => 'JPY', 'population' => 125836021],
            ['code' => 'KR', 'name' => 'South Korea', 'capital' => 'Seoul', 'region' => 'Asia', 'currency' => 'KRW', 'population' => 51780579],
            ['code' => 'IN', 'name' => 'India', 'capital' => 'New Delhi', 'region' => 'Asia', 'currency' => 'INR', 'population' => 1380004385],
            ['code' => 'AU', 'name' => 'Australia', 'capital' => 'Canberra', 'region' => 'Oceania', 'currency' => 'AUD', 'population' => 25499884],
            ['code' => 'NZ', 'name' => 'New Zealand', 'capital' => 'Wellington', 'region' => 'Oceania', 'currency' => 'NZD', 'population' => 4822233],
            ['code' => 'DE', 'name' => 'Germany', 'capital' => 'Berlin', 'region' => 'Europe', 'currency' => 'EUR', 'population' => 83240525],
            ['code' => 'FR', 'name' => 'France', 'capital' => 'Paris', 'region' => 'Europe', 'currency' => 'EUR', 'population' => 67391582],
            ['code' => 'IT', 'name' => 'Italy', 'capital' => 'Rome', 'region' => 'Europe', 'currency' => 'EUR', 'population' => 60262770],
            ['code' => 'ES', 'name' => 'Spain', 'capital' => 'Madrid', 'region' => 'Europe', 'currency' => 'EUR', 'population' => 47351567],
            ['code' => 'NL', 'name' => 'Netherlands', 'capital' => 'Amsterdam', 'region' => 'Europe', 'currency' => 'EUR', 'population' => 17134872],
            ['code' => 'GB', 'name' => 'United Kingdom', 'capital' => 'London', 'region' => 'Europe', 'currency' => 'GBP', 'population' => 67886011],
            ['code' => 'US', 'name' => 'United States', 'capital' => 'Washington, D.C.', 'region' => 'Americas', 'currency' => 'USD', 'population' => 331002651],
            ['code' => 'CA', 'name' => 'Canada', 'capital' => 'Ottawa', 'region' => 'Americas', 'currency' => 'CAD', 'population' => 37742154],
            ['code' => 'MX', 'name' => 'Mexico', 'capital' => 'Mexico City', 'region' => 'Americas', 'currency' => 'MXN', 'population' => 128932753],
            ['code' => 'BR', 'name' => 'Brazil', 'capital' => 'Brasília', 'region' => 'Americas', 'currency' => 'BRL', 'population' => 212559417],
            ['code' => 'AR', 'name' => 'Argentina', 'capital' => 'Buenos Aires', 'region' => 'Americas', 'currency' => 'ARS', 'population' => 45376763],
            ['code' => 'SA', 'name' => 'Saudi Arabia', 'capital' => 'Riyadh', 'region' => 'Asia', 'currency' => 'SAR', 'population' => 34813871],
            ['code' => 'AE', 'name' => 'United Arab Emirates', 'capital' => 'Abu Dhabi', 'region' => 'Asia', 'currency' => 'AED', 'population' => 9890402],
            ['code' => 'ZA', 'name' => 'South Africa', 'capital' => 'Pretoria', 'region' => 'Africa', 'currency' => 'ZAR', 'population' => 59308690],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                [
                    'name' => $country['name'],
                    'capital' => $country['capital'],
                    'region' => $country['region'],
                    'currency' => $country['currency'],
                    'population' => $country['population'],
                    'flag' => 'https://flagcdn.com/w320/' . strtolower($country['code']) . '.png',
                ]
            );
        }
    }
}
