<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Port;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $ports = require database_path('data/ports.php');

        foreach ($ports as $port) {

            $country = Country::where('code', $port['country_code'])->first();

            if (!$country) {
                continue;
            }

            Port::updateOrCreate(

                [
                    'wpi_number' => $port['wpi_number']
                ],

                [

                    'country_id'   => $country->id,

                    'country_code' => $port['country_code'],

                    'name'         => $port['name'],

                    'type'         => 'Seaport',

                    'harbor_type'  => $port['harbor_type'],

                    'harbor_size'  => $port['harbor_size'],

                    'latitude'     => $port['latitude'],

                    'longitude'    => $port['longitude'],

                    'status'       => 'Active',

                ]

            );

        }

        $this->command->info('Ports imported successfully.');
    }
}