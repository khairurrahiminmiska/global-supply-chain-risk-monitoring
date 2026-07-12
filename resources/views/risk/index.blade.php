@extends('layouts.main')

@section('content')

<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                ⚠️ Country Risk Score
            </h1>

            <p class="text-gray-500 mt-2">
                Global supply chain country risk monitoring
            </p>
        </div>

        <a
            href="{{ route('risk.analytics') }}"
            class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold transition"
        >
            📊 View Risk Analytics
        </a>

    </div>
</div>


{{-- SUMMARY CARDS --}}

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    <div class="bg-white border rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">Total Countries</p>

        <h2 class="text-3xl font-bold text-slate-800 mt-2">
            {{ $totalCountries }}
        </h2>
    </div>

    <div class="bg-white border rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">Low Risk</p>

        <h2 class="text-3xl font-bold text-green-600 mt-2">
            {{ $lowRisk }}
        </h2>
    </div>

    <div class="bg-white border rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">Medium Risk</p>

        <h2 class="text-3xl font-bold text-orange-500 mt-2">
            {{ $mediumRisk }}
        </h2>
    </div>

    <div class="bg-white border rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">High Risk</p>

        <h2 class="text-3xl font-bold text-red-600 mt-2">
            {{ $highRisk }}
        </h2>
    </div>

</div>


{{-- FILTER --}}

<div class="bg-white border rounded-2xl shadow-sm p-6 mb-8">

    <form
        method="GET"
        action="{{ route('risk.index') }}"
        class="flex flex-col md:flex-row gap-4"
    >

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search country..."
            class="border border-gray-300 rounded-xl px-4 py-3 flex-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        >

        <select
            name="level"
            class="border border-gray-300 rounded-xl px-4 py-3 md:w-64 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        >
            <option value="">All Risk Levels</option>

            <option value="LOW" @selected(request('level') === 'LOW')>
                Low Risk
            </option>

            <option value="MEDIUM" @selected(request('level') === 'MEDIUM')>
                Medium Risk
            </option>

            <option value="HIGH" @selected(request('level') === 'HIGH')>
                High Risk
            </option>
        </select>

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition"
        >
            🔍 Search
        </button>

        <a
            href="{{ route('risk.index') }}"
            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-semibold text-center transition"
        >
            Reset
        </a>

    </form>

</div>


{{-- RISK TABLE --}}

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

    <div class="p-6 border-b">

        <h2 class="text-xl font-bold text-slate-800">
            🌍 Global Risk Score
        </h2>

        <p class="text-gray-500 text-sm mt-1">
            Risk assessment based on weather, inflation, currency,
            news sentiment and port infrastructure
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr class="text-sm text-slate-600">

                    <th class="px-6 py-4 text-left">
                        Rank
                    </th>

                    <th class="px-6 py-4 text-left">
                        Country
                    </th>

                    <th class="px-6 py-4 text-center">
                        Weather
                    </th>

                    <th class="px-6 py-4 text-center">
                        Inflation
                    </th>

                    <th class="px-6 py-4 text-center">
                        Currency
                    </th>

                    <th class="px-6 py-4 text-center">
                        News
                    </th>

                    <th class="px-6 py-4 text-center">
                        Port
                    </th>

                    <th class="px-6 py-4 text-center">
                        Score
                    </th>

                    <th class="px-6 py-4 text-center">
                        Risk Level
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($riskScores as $risk)

                    <tr class="border-b hover:bg-slate-50 transition">

                        <td class="px-6 py-4 text-gray-500 font-semibold">

                            #{{ $riskScores->firstItem() + $loop->index }}

                        </td>


                        <td class="px-6 py-4">

                            <div class="font-semibold text-slate-800">

                                {{ $risk->country?->name ?? 'Unknown' }}

                            </div>

                            <div class="text-xs text-gray-400 mt-1">

                                {{ $risk->country?->code ?? '-' }}

                            </div>

                        </td>


                        <td class="px-6 py-4 text-center">

                            {{ $risk->weather_score }}

                        </td>


                        <td class="px-6 py-4 text-center">

                            {{ $risk->inflation_score }}

                        </td>


                        <td class="px-6 py-4 text-center">

                            {{ $risk->currency_score }}

                        </td>


                        <td class="px-6 py-4 text-center">

                            {{ $risk->news_score }}

                        </td>


                        <td class="px-6 py-4 text-center">

                            {{ $risk->port_score }}

                        </td>


                        <td class="px-6 py-4 text-center">

                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100">

                                <span class="text-lg font-bold text-slate-800">

                                    {{ $risk->total_score }}

                                </span>

                            </div>

                        </td>


                        <td class="px-6 py-4 text-center">

                            @if($risk->risk_level === 'HIGH')

                                <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                    🔴 HIGH
                                </span>

                            @elseif($risk->risk_level === 'MEDIUM')

                                <span class="inline-flex px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold">
                                    🟠 MEDIUM
                                </span>

                            @else

                                <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                    🟢 LOW
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="p-12 text-center"
                        >

                            <div class="text-4xl mb-3">
                                🔍
                            </div>

                            <p class="text-gray-500">
                                Risk score data not found.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- PAGINATION --}}

    @if($riskScores->hasPages())

        <div class="p-6 border-t">

            {{ $riskScores->links() }}

        </div>

    @endif

</div>

@endsection