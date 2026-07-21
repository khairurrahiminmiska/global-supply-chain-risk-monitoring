@extends('layouts.main')

@section('content')

@include('partials.nav.system')

<div class="space-y-8">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-slate-800">Articles</h1>
            <p class="text-gray-500 mt-2">Manage analysis articles</p>
        </div>
        <a href="{{ route('admin.articles.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg transition font-semibold">
            + New Article
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-5 py-3 text-left">Title</th>
                        <th class="px-5 py-3 text-left">Author</th>
                        <th class="px-5 py-3 text-left">Category</th>
                        <th class="px-5 py-3 text-left">Published</th>
                        <th class="px-5 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($articles as $article)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="px-5 py-4 font-medium max-w-xs truncate">{{ $article->title }}</td>
                        <td class="px-5 py-4 text-gray-600">{{ $article->author ?? '-' }}</td>
                        <td class="px-5 py-4">
                            @if($article->category)
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700">{{ $article->category }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-sm">
                            {{ $article->published_at ? $article->published_at->format('d M Y') : 'Draft' }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.articles.edit', $article) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-semibold transition">Edit</a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                      onsubmit="return confirm('Delete this article?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold transition">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-8 text-gray-500">No articles yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    </div>

</div>

@endsection
