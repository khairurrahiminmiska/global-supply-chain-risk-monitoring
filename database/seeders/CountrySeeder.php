<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('json/countries.json'));

        $countries = json_decode($json, true);

        foreach ($countries as $country) {

            Country::updateOrCreate(

                [
                    'code' => $country['code']
                ],

                [
                    'name'       => $country['name'],
                    'capital'    => $country['capital'],
                    'region'     => $country['region'],
                    'currency'   => $country['currency'],
                    'population' => $country['population'],
                    'flag'       => $country['flag'],
                ]

            );

        }
    }
}