<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\News;
use Illuminate\Http\Request;

class NewsIntelligenceController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query()
            ->with('country');

        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }

        if ($request->filled('sentiment')) {
            $query->where(
                'sentiment',
                $request->sentiment
            );
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($newsQuery) use ($search) {
                $newsQuery
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere(
                        'description',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'source',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        $newsItems = $query
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $countries = Country::query()
            ->orderBy('name')
            ->get();

        $totalNews = News::query()->count();

        $positiveNews = News::query()
            ->where('sentiment', 'Positive')
            ->count();

        $negativeNews = News::query()
            ->where('sentiment', 'Negative')
            ->count();

        $neutralNews = News::query()
            ->where('sentiment', 'Neutral')
            ->count();

        $highestNegativeCountry = Country::query()
            ->withCount([
                'news as negative_news_count' => function ($query) {
                    $query->where(
                        'sentiment',
                        'Negative'
                    );
                },
            ])
            ->orderByDesc('negative_news_count')
            ->first();

        return view('news.index', compact(
            'newsItems',
            'countries',
            'totalNews',
            'positiveNews',
            'negativeNews',
            'neutralNews',
            'highestNegativeCountry'
        ));
    }
}