<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Port;

class PortImportService
{
    public function import($path)
    {
        $handle = fopen($path, "r");

        if (!$handle) {
            throw new \Exception("CSV tidak dapat dibuka.");
        }

        $header = fgetcsv($handle);

        dd($header);

        while (($row = fgetcsv($handle)) !== false) {

            $data = array_combine($header, $row);

            $countryCode = trim($data['Country Code'] ?? '');

            $country = Country::where('code', $countryCode)->first();

            if (!$country) {
                continue;
            }

            Port::updateOrCreate(

                [

                    'wpi_number' => trim($data['World Port Index Number'])

                ],

                [

                    'country_id' => $country->id,

                    'country_code' => $countryCode,

                    'name' => trim($data['Main Port Name']),

                    'harbor_size' => trim($data['Harbor Size']),

                    'harbor_type' => trim($data['Harbor Type']),

                    'latitude' => (float) $data['Latitude'],

                    'longitude' => (float) $data['Longitude'],

                    'status' => 'Active'

                ]

            );
        }

        fclose($handle);
    }
}