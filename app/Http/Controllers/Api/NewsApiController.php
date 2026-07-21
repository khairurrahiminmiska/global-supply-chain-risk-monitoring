<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $news = $query
            ->latest('published_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'News retrieved successfully.',
            'total' => $news->count(),
            'data' => $news,
        ]);
    }
}