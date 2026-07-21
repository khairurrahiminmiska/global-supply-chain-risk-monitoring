<?php

namespace App\Services;

use App\Models\Country;

class CountryImportService
{
    public function import($path)
    {
        $handle = fopen($path, "r");

        if (!$handle) {
            throw new \Exception("CSV tidak dapat dibuka.");
        }

        $header = fgetcsv($handle);

        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            $code = strtoupper(trim($data['code'] ?? ''));
            if (!$code) continue;

            $population = (int) preg_replace('/[^0-9]/', '', $data['population'] ?? 0);

            Country::updateOrCreate(
                ['code' => $code],
                [
                    'name' => trim($data['name'] ?? ''),
                    'capital' => trim($data['capital'] ?? ''),
                    'region' => trim($data['region'] ?? ''),
                    'currency' => strtoupper(trim($data['currency'] ?? '')),
                    'population' => $population,
                    'flag' => 'https://flagcdn.com/w320/' . strtolower($code) . '.png',
                ]
            );

            $imported++;
        }

        fclose($handle);

        return $imported;
    }
}
