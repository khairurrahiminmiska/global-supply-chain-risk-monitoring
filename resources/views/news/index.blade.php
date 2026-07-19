@extends('layouts.main')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-widest">
                Global Intelligence
            </p>

            <h1 class="text-3xl font-bold text-slate-900 mt-2">
                News Intelligence
            </h1>

            <p class="text-slate-500 mt-2">
                Global news sentiment monitoring for supply chain risk intelligence.
            </p>
        </div>

        <div class="px-5 py-3 bg-emerald-50 rounded-2xl">
            <p class="text-xs text-emerald-600 font-semibold uppercase">
                Intelligence Coverage
            </p>

            <p class="text-2xl font-bold text-emerald-700 mt-1">
                {{ number_format($totalNews) }} News
            </p>
        </div>

    </div>


    {{-- STATISTICS --}}

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-slate-500">
                Total News
            </p>

            <p class="text-3xl font-bold text-slate-900 mt-3">
                {{ number_format($totalNews) }}
            </p>
        </div>


        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-slate-500">
                Positive Intelligence
            </p>

            <p class="text-3xl font-bold text-emerald-600 mt-3">
                {{ number_format($positiveNews) }}
            </p>
        </div>


        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-slate-500">
                Negative Intelligence
            </p>

            <p class="text-3xl font-bold text-red-600 mt-3">
                {{ number_format($negativeNews) }}
            </p>
        </div>


        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-slate-500">
                Neutral Intelligence
            </p>

            <p class="text-3xl font-bold text-amber-600 mt-3">
                {{ number_format($neutralNews) }}
            </p>
        </div>

    </div>


    {{-- NEGATIVE COUNTRY INTELLIGENCE --}}

    @if(
        $highestNegativeCountry &&
        $highestNegativeCountry->negative_news_count > 0
    )

        <div class="bg-red-50 border border-red-100 rounded-2xl p-6">

            <p class="text-xs font-bold text-red-500 uppercase tracking-widest">
                Intelligence Warning
            </p>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-3">

                <div>
                    <h2 class="text-xl font-bold text-red-900">
                        {{ $highestNegativeCountry->name }}
                    </h2>

                    <p class="text-red-700 mt-1">
                        Country with the highest detected negative news sentiment.
                    </p>
                </div>

                <div class="text-left md:text-right">

                    <p class="text-3xl font-bold text-red-600">
                        {{ $highestNegativeCountry->negative_news_count }}
                    </p>

                    <p class="text-sm text-red-500">
                        Negative News
                    </p>

                </div>

            </div>

        </div>

    @endif


    {{-- FILTER --}}

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">

        <form
            method="GET"
            action="{{ route('news.index') }}"
            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search intelligence..."
                class="rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500"
            >


            <select
                name="country"
                class="rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500"
            >

                <option value="">
                    All Countries
                </option>

                @foreach($countries as $country)

                    <option
                        value="{{ $country->id }}"
                        @selected(
                            request('country') == $country->id
                        )
                    >
                        {{ $country->name }}
                    </option>

                @endforeach

            </select>


            <select
                name="sentiment"
                class="rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500"
            >

                <option value="">
                    All Sentiments
                </option>

                <option
                    value="Positive"
                    @selected(request('sentiment') === 'Positive')
                >
                    Positive
                </option>

                <option
                    value="Neutral"
                    @selected(request('sentiment') === 'Neutral')
                >
                    Neutral
                </option>

                <option
                    value="Negative"
                    @selected(request('sentiment') === 'Negative')
                >
                    Negative
                </option>

            </select>


            <button
                type="submit"
                class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl px-5 py-3 transition"
            >
                Analyze Intelligence
            </button>

        </form>

    </div>


    {{-- NEWS LIST --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        @forelse($newsItems as $news)

            @php

                $sentimentClass = match($news->sentiment) {
                    'Positive' => 'bg-emerald-50 text-emerald-700',
                    'Negative' => 'bg-red-50 text-red-700',
                    default => 'bg-amber-50 text-amber-700',
                };

            @endphp

            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">
                            {{ $news->country?->name ?? 'Global' }}
                        </p>

                        <h2 class="text-lg font-bold text-slate-900 mt-2 leading-snug">
                            {{ $news->title }}
                        </h2>

                    </div>


                    <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $sentimentClass }}">
                        {{ strtoupper($news->sentiment ?? 'Neutral') }}
                    </span>

                </div>


                <p class="text-sm text-slate-500 mt-4 leading-relaxed">
                    {{ \Illuminate\Support\Str::limit(
                        $news->description ?: 'No description available.',
                        220
                    ) }}
                </p>


                <div class="grid grid-cols-2 gap-4 mt-5">

                    <div class="bg-slate-50 rounded-xl p-4">

                        <p class="text-xs text-slate-500">
                            Positive Score
                        </p>

                        <p class="text-lg font-bold text-emerald-600 mt-1">
                            {{ $news->positive_score }}
                        </p>

                    </div>


                    <div class="bg-slate-50 rounded-xl p-4">

                        <p class="text-xs text-slate-500">
                            Negative Score
                        </p>

                        <p class="text-lg font-bold text-red-600 mt-1">
                            {{ $news->negative_score }}
                        </p>

                    </div>

                </div>


                <div class="flex items-center justify-between gap-4 mt-5 pt-5 border-t border-slate-100">

                    <div>

                        <p class="text-xs text-slate-400">
                            {{ $news->source ?: 'Unknown Source' }}
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            {{ $news->published_at
                                ? \Carbon\Carbon::parse($news->published_at)->format('d M Y H:i')
                                : 'Unknown Date'
                            }}
                        </p>

                    </div>


                    @if($news->url)

                        <a
                            href="{{ $news->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-sm font-semibold text-emerald-600 hover:text-emerald-700"
                        >
                            Read Source →
                        </a>

                    @endif

                </div>

            </div>

        @empty

            <div class="xl:col-span-2 bg-white border border-slate-200 rounded-2xl p-12 text-center">

                <p class="text-lg font-semibold text-slate-700">
                    No intelligence data found.
                </p>

                <p class="text-sm text-slate-500 mt-2">
                    Synchronize country news data to generate global news intelligence.
                </p>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}

    @if($newsItems->hasPages())

        <div>
            {{ $newsItems->links() }}
        </div>

    @endif

</div>

@endsection