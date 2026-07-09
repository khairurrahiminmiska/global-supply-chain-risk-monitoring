<?php

namespace App\Services;

use App\Models\Country;
use App\Models\News;
use Illuminate\Support\Facades\Http;
use App\Services\SentimentService;

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
        $sentimentService = new SentimentService();

foreach ($json['results'] as $item) {

    $content =

        ($item['title'] ?? '') . ' ' .

        ($item['description'] ?? '');

    $result = $sentimentService->analyze($content);

    News::updateOrCreate(

        [

            'url' => $item['link'] ?? ''

        ],

        [

            'country_id' => $country->id,

            'title' => $item['title'] ?? '',

            'description' => $item['description'] ?? '',

            'source' => parse_url($item['link'] ?? '', PHP_URL_HOST),

            'url' => $item['link'] ?? '',

            'image' => null,

            'published_at' => $item['pubDate'] ?? now(),

            'positive_score' => $result['positive'],

            'negative_score' => $result['negative'],

            'sentiment' => $result['sentiment']

        ]

    );

}

        return true;
    }
}