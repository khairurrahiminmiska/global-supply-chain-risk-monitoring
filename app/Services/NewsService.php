<?php

namespace App\Services;

use App\Models\Country;
use App\Models\News;
use Illuminate\Support\Facades\Http;

class NewsService
{
    public function sync(Country $country, $category = 'economy')
    {
        $apiKey = env('NEWSDATA_API_KEY');

        $language = $country->code == 'ID'
            ? 'id'
            : 'en';

        $response = Http::get(
            'https://newsdata.io/api/1/latest',
            [
                'apikey'  => $apiKey,
                'q'       => $country->name . ' ' . $category,
                'language'=> $language,
            ]
        );

        if (!$response->successful()) {
            return false;
        }

        $json = $response->json();

        if (!isset($json['results'])) {
            return false;
        }

        // Hapus berita lama negara ini agar tidak menumpuk
        News::where('country_id', $country->id)->delete();

        foreach ($json['results'] as $item) {

            News::create([
                'country_id'  => $country->id,
                'title'       => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'source'      => parse_url($item['link'] ?? '', PHP_URL_HOST),
                'url'         => $item['link'] ?? '',
                'image'       => null,
                'published_at'=> $item['pubDate'] ?? now(),
            ]);

        }

        return true;
    }
}