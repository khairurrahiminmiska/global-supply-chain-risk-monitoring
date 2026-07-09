<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [

            [
                'name'=>'Indonesia',
                'code'=>'ID',
                'capital'=>'Jakarta',
                'region'=>'Asia',
                'currency'=>'IDR',
                'population'=>281000000,
                'flag'=>'https://flagcdn.com/w320/id.png',
            ],

            [
                'name'=>'Malaysia',
                'code'=>'MY',
                'capital'=>'Kuala Lumpur',
                'region'=>'Asia',
                'currency'=>'MYR',
                'population'=>35000000,
                'flag'=>'https://flagcdn.com/w320/my.png',
                
            ],

            [
                'name'=>'Singapore',
                'code'=>'SG',
                'capital'=>'Singapore',
                'region'=>'Asia',
                'currency'=>'SGD',
                'population'=>6000000,
                
            ],

            [
                'name'=>'Thailand',
                'code'=>'TH',
                'capital'=>'Bangkok',
                'region'=>'Asia',
                'currency'=>'THB',
                'population'=>71000000,
                
            ],

            [
                'name'=>'Vietnam',
                'code'=>'VN',
                'capital'=>'Hanoi',
                'region'=>'Asia',
                'currency'=>'VND',
                'population'=>100000000,
                
            ],

            [
                'name'=>'China',
                'code'=>'CN',
                'capital'=>'Beijing',
                'region'=>'Asia',
                'currency'=>'CNY',
                'population'=>1412000000,
                'flag'=>'https://flagcdn.com/w320/cn.png',
                
            ],

            [
                'name'=>'Japan',
                'code'=>'JP',
                'capital'=>'Tokyo',
                'region'=>'Asia',
                'currency'=>'JPY',
                'population'=>124000000,
                
            ],

            [
                'name'=>'South Korea',
                'code'=>'KR',
                'capital'=>'Seoul',
                'region'=>'Asia',
                'currency'=>'KRW',
                'population'=>52000000,
                
            ],

            [
                'name'=>'India',
                'code'=>'IN',
                'capital'=>'New Delhi',
                'region'=>'Asia',
                'currency'=>'INR',
                'population'=>1430000000,
            ],

            [
                'name'=>'Australia',
                'code'=>'AU',
                'capital'=>'Canberra',
                'region'=>'Oceania',
                'currency'=>'AUD',
                'population'=>27000000,
                'flag'=>'https://flagcdn.com/w320/au.png',
            ],

            [
                'name'=>'Germany',
                'code'=>'DE',
                'capital'=>'Berlin',
                'region'=>'Europe',
                'currency'=>'EUR',
                'population'=>84000000,
            ],

            [
                'name'=>'France',
                'code'=>'FR',
                'capital'=>'Paris',
                'region'=>'Europe',
                'currency'=>'EUR',
                'population'=>68000000,
            ],

            [
                'name'=>'United States',
                'code'=>'US',
                'capital'=>'Washington DC',
                'region'=>'America',
                'currency'=>'USD',
                'population'=>340000000,
            ],

            [
                'name'=>'Canada',
                'code'=>'CA',
                'capital'=>'Ottawa',
                'region'=>'America',
                'currency'=>'CAD',
                'population'=>41000000,
            ],

            [
                'name'=>'Brazil',
                'code'=>'BR',
                'capital'=>'Brasilia',
                'region'=>'America',
                'currency'=>'BRL',
                'population'=>212000000,
            ],

        ];

        foreach($countries as $country){

            Country::updateOrCreate(

                ['code'=>$country['code']],

                $country

            );

        }

    }
}