@extends('layouts.main')

@section('content')

@include('partials.nav.country')

<div class="space-y-8">

    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Country Watchlist
        </h1>
        <p class="text-gray-500 mt-2">
            Your monitored countries
        </p>
    </div>

    @if($watchlists->count())

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($watchlists as $item)

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition">

                    <div class="p-6">

                        <div class="flex items-center gap-4 mb-4">

                            @if($item->country->flag)

                                <img src="{{ $item->country->flag }}"
                                     alt="{{ $item->country->name }}"
                                     class="w-14 h-10 rounded-lg object-cover border">

                            @endif

                            <div>
                                <h3 class="text-xl font-bold text-slate-800">
                                    {{ $item->country->name }}
                                </h3>
                                <p class="text-sm text-slate-500">
                                    {{ $item->country->code }} &middot; {{ $item->country->region }}
                                </p>
                            </div>

                        </div>

                        <div class="grid grid-cols-3 gap-3 text-center mb-5">

                            <div class="bg-blue-50 rounded-xl py-3">
                                <p class="text-xs text-slate-500">Risk</p>
                                <p class="text-lg font-bold text-slate-800">
                                    {{ $item->country->riskScore?->total_score ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-green-50 rounded-xl py-3">
                                <p class="text-xs text-slate-500">GDP</p>
                                <p class="text-lg font-bold text-slate-800 truncate">
                                    @php
                                        $g = $item->country->gdp;
                                        if ($g >= 1e12) { echo '$'.number_format($g/1e12,1).'T'; }
                                        elseif ($g >= 1e9) { echo '$'.number_format($g/1e9,1).'B'; }
                                        elseif ($g >= 1e6) { echo '$'.number_format($g/1e6,1).'M'; }
                                        elseif ($g) { echo '$'.number_format($g,0); }
                                        else { echo '-'; }
                                    @endphp
                                </p>
                            </div>

                            <div class="bg-yellow-50 rounded-xl py-3">
                                <p class="text-xs text-slate-500">Inflation</p>
                                <p class="text-lg font-bold text-slate-800 truncate">
                                    {{ $item->country->inflation ? number_format($item->country->inflation,1).'%' : '-' }}
                                </p>
                            </div>

                        </div>

                        <div class="flex gap-3">

                            <a href="{{ route('countries.show', $item->country) }}"
                               class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl font-semibold transition text-sm">
                                View Details
                            </a>

                            <form action="{{ route('watchlist.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Remove from watchlist?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-3 rounded-xl font-semibold transition text-sm">
                                    Remove
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div>
            {{ $watchlists->links() }}
        </div>

    @else

        <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center">

            <div class="text-5xl text-slate-300 font-bold mb-4">*</div>

            <h2 class="text-xl font-bold text-slate-700">
                No countries in your watchlist
            </h2>

            <p class="text-slate-500 mt-2">
                Browse countries and click "Add to Watchlist" to start monitoring.
            </p>

            <a href="{{ route('countries.index') }}"
               class="inline-block mt-6 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                Browse Countries
            </a>

        </div>

    @endif

</div>

@endsection
