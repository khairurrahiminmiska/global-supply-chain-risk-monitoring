<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [

            [
                'name' => 'Indonesia',
                'code' => 'ID',
                'capital' => 'Jakarta',
                'region' => 'Asia',
                'currency' => 'IDR',
                'population' => 281000000,
                'flag' => 'https://flagcdn.com/w320/id.png',
            ],

            [
                'name' => 'Malaysia',
                'code' => 'MY',
                'capital' => 'Kuala Lumpur',
                'region' => 'Asia',
                'currency' => 'MYR',
                'population' => 35000000,
                'flag' => 'https://flagcdn.com/w320/my.png',

            ],

            [
                'name' => 'Singapore',
                'code' => 'SG',
                'capital' => 'Singapore',
                'region' => 'Asia',
                'currency' => 'SGD',
                'population' => 6000000,

            ],

            [
                'name' => 'Thailand',
                'code' => 'TH',
                'capital' => 'Bangkok',
                'region' => 'Asia',
                'currency' => 'THB',
                'population' => 71000000,

            ],

            [
                'name' => 'Vietnam',
                'code' => 'VN',
                'capital' => 'Hanoi',
                'region' => 'Asia',
                'currency' => 'VND',
                'population' => 100000000,

            ],

            [
                'name' => 'China',
                'code' => 'CN',
                'capital' => 'Beijing',
                'region' => 'Asia',
                'currency' => 'CNY',
                'population' => 1412000000,
                'flag' => 'https://flagcdn.com/w320/cn.png',

            ],

            [
                'name' => 'Japan',
                'code' => 'JP',
                'capital' => 'Tokyo',
                'region' => 'Asia',
                'currency' => 'JPY',
                'population' => 124000000,

            ],

            [
                'name' => 'South Korea',
                'code' => 'KR',
                'capital' => 'Seoul',
                'region' => 'Asia',
                'currency' => 'KRW',
                'population' => 52000000,

            ],

            [
                'name' => 'India',
                'code' => 'IN',
                'capital' => 'New Delhi',
                'region' => 'Asia',
                'currency' => 'INR',
                'population' => 1430000000,
            ],

            [
                'name' => 'Australia',
                'code' => 'AU',
                'capital' => 'Canberra',
                'region' => 'Oceania',
                'currency' => 'AUD',
                'population' => 27000000,
                'flag' => 'https://flagcdn.com/w320/au.png',
            ],

            [
                'name' => 'Germany',
                'code' => 'DE',
                'capital' => 'Berlin',
                'region' => 'Europe',
                'currency' => 'EUR',
                'population' => 84000000,
            ],

            [
                'name' => 'France',
                'code' => 'FR',
                'capital' => 'Paris',
                'region' => 'Europe',
                'currency' => 'EUR',
                'population' => 68000000,
            ],

            [
                'name' => 'United States',
                'code' => 'US',
                'capital' => 'Washington DC',
                'region' => 'America',
                'currency' => 'USD',
                'population' => 340000000,
            ],

            [
                'name' => 'Canada',
                'code' => 'CA',
                'capital' => 'Ottawa',
                'region' => 'America',
                'currency' => 'CAD',
                'population' => 41000000,
            ],

            [
                'name' => 'Brazil',
                'code' => 'BR',
                'capital' => 'Brasilia',
                'region' => 'America',
                'currency' => 'BRL',
                'population' => 212000000,
            ],

            // ===== 15 Negara Tambahan =====

            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'capital' => 'London',
                'region' => 'Europe',
                'currency' => 'GBP',
                'population' => 68000000,
                'flag' => 'https://flagcdn.com/w320/gb.png',
            ],

            [
                'name' => 'Italy',
                'code' => 'IT',
                'capital' => 'Rome',
                'region' => 'Europe',
                'currency' => 'EUR',
                'population' => 59000000,
                'flag' => 'https://flagcdn.com/w320/it.png',
            ],

            [
                'name' => 'Spain',
                'code' => 'ES',
                'capital' => 'Madrid',
                'region' => 'Europe',
                'currency' => 'EUR',
                'population' => 48000000,
                'flag' => 'https://flagcdn.com/w320/es.png',
            ],

            [
                'name' => 'Netherlands',
                'code' => 'NL',
                'capital' => 'Amsterdam',
                'region' => 'Europe',
                'currency' => 'EUR',
                'population' => 18000000,
                'flag' => 'https://flagcdn.com/w320/nl.png',
            ],

            [
                'name' => 'Mexico',
                'code' => 'MX',
                'capital' => 'Mexico City',
                'region' => 'America',
                'currency' => 'MXN',
                'population' => 130000000,
                'flag' => 'https://flagcdn.com/w320/mx.png',
            ],

            [
                'name' => 'Argentina',
                'code' => 'AR',
                'capital' => 'Buenos Aires',
                'region' => 'America',
                'currency' => 'ARS',
                'population' => 46000000,
                'flag' => 'https://flagcdn.com/w320/ar.png',
            ],

            [
                'name' => 'Saudi Arabia',
                'code' => 'SA',
                'capital' => 'Riyadh',
                'region' => 'Asia',
                'currency' => 'SAR',
                'population' => 36000000,
                'flag' => 'https://flagcdn.com/w320/sa.png',
            ],

            [
                'name' => 'United Arab Emirates',
                'code' => 'AE',
                'capital' => 'Abu Dhabi',
                'region' => 'Asia',
                'currency' => 'AED',
                'population' => 10000000,
                'flag' => 'https://flagcdn.com/w320/ae.png',
            ],

            [
                'name' => 'Turkey',
                'code' => 'TR',
                'capital' => 'Ankara',
                'region' => 'Asia',
                'currency' => 'TRY',
                'population' => 85000000,
                'flag' => 'https://flagcdn.com/w320/tr.png',
            ],

            [
                'name' => 'Russia',
                'code' => 'RU',
                'capital' => 'Moscow',
                'region' => 'Europe',
                'currency' => 'RUB',
                'population' => 144000000,
                'flag' => 'https://flagcdn.com/w320/ru.png',
            ],

            [
                'name' => 'South Africa',
                'code' => 'ZA',
                'capital' => 'Pretoria',
                'region' => 'Africa',
                'currency' => 'ZAR',
                'population' => 60000000,
                'flag' => 'https://flagcdn.com/w320/za.png',
            ],

            [
                'name' => 'Nigeria',
                'code' => 'NG',
                'capital' => 'Abuja',
                'region' => 'Africa',
                'currency' => 'NGN',
                'population' => 220000000,
                'flag' => 'https://flagcdn.com/w320/ng.png',
            ],

            [
                'name' => 'Bangladesh',
                'code' => 'BD',
                'capital' => 'Dhaka',
                'region' => 'Asia',
                'currency' => 'BDT',
                'population' => 170000000,
                'flag' => 'https://flagcdn.com/w320/bd.png',
            ],

            [
                'name' => 'Philippines',
                'code' => 'PH',
                'capital' => 'Manila',
                'region' => 'Asia',
                'currency' => 'PHP',
                'population' => 115000000,
                'flag' => 'https://flagcdn.com/w320/ph.png',
            ],

            [
                'name' => 'New Zealand',
                'code' => 'NZ',
                'capital' => 'Wellington',
                'region' => 'Oceania',
                'currency' => 'NZD',
                'population' => 5000000,
                'flag' => 'https://flagcdn.com/w320/nz.png',
            ],

        ];

        foreach ($countries as $country) {

            Country::updateOrCreate(

                ['code' => $country['code']],

                $country

            );

        }

    }
}
