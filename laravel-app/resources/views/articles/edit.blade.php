@extends('layouts.main')

@section('content')

@include('partials.nav.system')

<div class="space-y-8">

    <div>
        <h1 class="text-4xl font-bold text-slate-800">Edit Article</h1>
        <p class="text-gray-500 mt-2">Update analysis article</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-3xl">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title', $article->title) }}" required
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Author</label>
                    <input type="text" name="author" value="{{ old('author', $article->author) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                    <select name="category"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select category</option>
                        <option value="Analysis" @selected(old('category', $article->category) === 'Analysis')>Analysis</option>
                        <option value="Market Report" @selected(old('category', $article->category) === 'Market Report')>Market Report</option>
                        <option value="Risk Assessment" @selected(old('category', $article->category) === 'Risk Assessment')>Risk Assessment</option>
                        <option value="Policy Update" @selected(old('category', $article->category) === 'Policy Update')>Policy Update</option>
                        <option value="Industry News" @selected(old('category', $article->category) === 'Industry News')>Industry News</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Published At</label>
                <input type="date" name="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d')) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Leave empty for draft</p>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Content</label>
                <textarea name="content" rows="16" required
                          class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono text-sm">{{ old('content', $article->content) }}</textarea>
                @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl shadow-lg transition font-semibold">
                    Update Article
                </button>
                <a href="{{ route('admin.articles.index') }}"
                   class="text-slate-600 hover:text-slate-800 font-semibold transition">Cancel</a>
            </div>

        </form>
    </div>

</div>

@endsection
