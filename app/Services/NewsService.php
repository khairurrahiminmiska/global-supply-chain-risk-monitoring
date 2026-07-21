<?php

namespace App\Services;

use App\Models\Country;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsService
{
    /**
     * Sync news untuk satu negara
     */
    public function sync(
        Country $country,
        string $category = 'economy'
    ): bool {

        try {

            $language = strtoupper($country->code) === 'ID'
                ? 'id'
                : 'en';

            $query = $this->buildQuery(
                $country,
                $category
            );

            /*
            |--------------------------------------------------------------------------
            | 1. Coba GNews API dulu
            |--------------------------------------------------------------------------
            */

            $gnewsResult = $this->syncFromGNews(
                $country,
                $query,
                $language
            );

            if ($gnewsResult) {
                return true;
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Fallback ke NewsData.io
            |--------------------------------------------------------------------------
            */

            Log::info('GNews empty, trying NewsData.io', [
                'country' => $country->name,
            ]);

            $newsDataResult = $this->syncFromNewsData(
                $country,
                $query,
                $language
            );

            return $newsDataResult;

        } catch (\Throwable $exception) {

            Log::error('News synchronization failed.', [

                'country' => $country->name,

                'message' => $exception->getMessage(),

            ]);

            return false;

        }

    }

    /**
     * Sync dari GNews API
     */
    private function syncFromGNews(
        Country $country,
        string $query,
        string $language
    ): bool {

        $apiKey = env('GNEWS_API_KEY');

        if (! $apiKey) {
            return false;
        }

        $supportedCountries = [
            'ar', 'au', 'br', 'ca', 'cn', 'eg', 'fr', 'de', 'gr', 'hk',
            'in', 'ie', 'il', 'it', 'jp', 'kr', 'my', 'mx', 'ng', 'pk',
            'pe', 'ph', 'pl', 'pt', 'ro', 'ru', 'sg', 'za', 'se', 'tw',
            'tr', 'ua', 'gb', 'us',
        ];

        $params = [
            'q' => $query,
            'lang' => $language,
            'max' => 10,
            'sortby' => 'publishedAt',
            'apikey' => $apiKey,
        ];

        $code = strtolower($country->code);

        if (in_array($code, $supportedCountries)) {
            $params['country'] = $code;
        }

        $response = Http::timeout(30)
            ->retry(2, 1000)
            ->get(
                'https://gnews.io/api/v4/search',
                $params
            );

        if (! $response->successful()) {

            Log::warning('GNews API request failed.', [

                'country' => $country->name,

                'status' => $response->status(),

            ]);

            return false;

        }

        $articles = $response->json('articles', []);

        if (empty($articles)) {
            return false;
        }

        $this->saveArticles($country, $articles, 'gnews');

        return true;

    }

    /**
     * Sync dari NewsData.io API
     */
    private function syncFromNewsData(
        Country $country,
        string $query,
        string $language
    ): bool {

        $apiKey = env('NEWSDATA_API_KEY');

        if (! $apiKey) {

            Log::warning('NewsData API key is missing.');

            return false;

        }

        $params = [
            'apiKey' => $apiKey,
            'q' => $query,
            'language' => $language,
        ];

        $response = Http::timeout(30)
            ->retry(2, 1000)
            ->get(
                'https://newsdata.io/api/1/latest',
                $params
            );

        if (! $response->successful()) {

            Log::warning('NewsData API request failed.', [

                'country' => $country->name,

                'status' => $response->status(),

            ]);

            return false;

        }

        $articles = $response->json('results', []);

        if (empty($articles)) {

            Log::warning('NewsData articles not found.', [

                'country' => $country->name,

                'query' => $query,

            ]);

            return false;

        }

        $this->saveArticles($country, $articles, 'newsdata');

        return true;

    }

    /**
     * Simpan articles ke database
     */
    private function saveArticles(
        Country $country,
        array $articles,
        string $source
    ): void {

        $sentimentService = app(
            SentimentService::class
        );

        foreach ($articles as $article) {

            $url = $article['url']
                ?? $article['link']
                ?? null;

            if (! $url) {
                continue;
            }

            $title = $article['title'] ?? '';

            $description = $article['description']
                ?? $article['content']
                ?? '';

            $content = trim(
                $title.' '.$description
            );

            $sentiment = $sentimentService
                ->analyze($content);

            $publishedAt = $article['publishedAt']
                ?? $article['pubDate']
                ?? null;

            $source = $source === 'newsdata'
                ? ($article['source_name'] ?? 'Unknown')
                : data_get($article, 'source.name', 'Unknown');

            News::updateOrCreate(

                [
                    'url' => $url,
                ],

                [

                    'country_id' => $country->id,

                    'title' => $title,

                    'description' => $description,

                    'source' => $source,

                    'url' => $url,

                    'image' => substr(
                        $article['image_url']
                            ?? $article['image']
                            ?? '',
                        0,
                        2000
                    ),

                    'published_at' => ! empty($publishedAt)
                        ? Carbon::parse($publishedAt)
                        : now(),

                    'positive_score' => $sentiment['positive'],

                    'negative_score' => $sentiment['negative'],

                    'sentiment' => $sentiment['sentiment'],

                ]

            );

        }

    }

    /**
     * Sync seluruh negara
     */
    public function syncAll(
        string $category = 'economy'
    ): array {

        $success = 0;
        $failed = 0;

        Country::query()
            ->orderBy('id')
            ->chunkById(
                50,
                function ($countries) use (
                    &$success,
                    &$failed,
                    $category
                ) {

                    foreach ($countries as $country) {

                        if (
                            $this->sync(
                                $country,
                                $category
                            )
                        ) {

                            $success++;

                        } else {

                            $failed++;

                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Rate Limit
                        |--------------------------------------------------------------------------
                        */

                        usleep(1100000);

                    }

                }
            );

        return [

            'success' => $success,

            'failed' => $failed,

        ];

    }

    /**
     * Build query
     */
    private function buildQuery(
        Country $country,
        string $category
    ): string {

        return match (strtolower($category)) {

            'economy' => "{$country->name} economy",

            'trade' => "{$country->name} trade",

            'logistics' => "{$country->name} logistics",

            'shipping' => "{$country->name} shipping",

            'geopolitics' => "{$country->name} politics",

            default => $country->name,

        };

    }
}
