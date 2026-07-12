@extends('layouts.main')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        ⚠️ Global Risk Analytics
    </h1>

    <p class="text-gray-500 mt-2">
        Supply chain risk scoring and global country monitoring
    </p>

</div>


{{-- SUMMARY CARDS --}}

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <p class="text-gray-500 text-sm">
            High Risk Countries
        </p>

        <h2 class="text-4xl font-bold text-red-600 mt-3">
            {{ $highRisk }}
        </h2>

        <p class="text-red-500 text-sm mt-2">
            Critical supply chain risk
        </p>

    </div>


    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <p class="text-gray-500 text-sm">
            Medium Risk Countries
        </p>

        <h2 class="text-4xl font-bold text-orange-500 mt-3">
            {{ $mediumRisk }}
        </h2>

        <p class="text-orange-500 text-sm mt-2">
            Monitoring required
        </p>

    </div>


    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <p class="text-gray-500 text-sm">
            Low Risk Countries
        </p>

        <h2 class="text-4xl font-bold text-green-600 mt-3">
            {{ $lowRisk }}
        </h2>

        <p class="text-green-600 text-sm mt-2">
            Stable supply chain
        </p>

    </div>


    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <p class="text-gray-500 text-sm">
            Average Risk Score
        </p>

        <h2 class="text-4xl font-bold text-blue-600 mt-3">
            {{ $averageScore }}
        </h2>

        <p class="text-blue-500 text-sm mt-2">
            Global risk average
        </p>

    </div>

</div>


{{-- HIGHEST RISK --}}

@if($highestRisk)

<div class="bg-gradient-to-r from-red-600 to-orange-500 text-white rounded-2xl p-7 mb-8">

    <p class="text-red-100 text-sm">
        Highest Risk Country
    </p>

    <div class="flex flex-wrap justify-between items-center mt-3">

        <div>

            <h2 class="text-3xl font-bold">
                {{ $highestRisk->country->name }}
            </h2>

            <p class="mt-2 text-red-100">
                Highest detected global supply chain risk
            </p>

        </div>

        <div class="text-right">

            <p class="text-5xl font-bold">
                {{ $highestRisk->total_score }}
            </p>

            <span class="inline-block bg-white/20 px-4 py-2 rounded-full mt-2">
                {{ $highestRisk->risk_level }}
            </span>

        </div>

    </div>

</div>

@endif


{{-- CHART --}}

<div class="bg-white rounded-2xl shadow-sm border p-6 mb-8">

    <div class="mb-6">

        <h2 class="text-xl font-bold text-slate-800">
            📊 Global Risk Ranking
        </h2>

        <p class="text-gray-500 text-sm mt-1">
            Country risk score comparison
        </p>

    </div>

    <div style="height: 420px;">

        <canvas id="riskChart"></canvas>

    </div>

</div>


{{-- RISK TABLE --}}

<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

    <div class="p-6 border-b">

        <h2 class="text-xl font-bold text-slate-800">
            🌍 Country Risk Ranking
        </h2>

        <p class="text-gray-500 text-sm mt-1">
            Risk analysis based on five supply chain indicators
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="px-5 py-4 text-left">
                        Rank
                    </th>

                    <th class="px-5 py-4 text-left">
                        Country
                    </th>

                    <th class="px-5 py-4 text-center">
                        Weather
                    </th>

                    <th class="px-5 py-4 text-center">
                        Inflation
                    </th>

                    <th class="px-5 py-4 text-center">
                        Currency
                    </th>

                    <th class="px-5 py-4 text-center">
                        News
                    </th>

                    <th class="px-5 py-4 text-center">
                        Port
                    </th>

                    <th class="px-5 py-4 text-center">
                        Score
                    </th>

                    <th class="px-5 py-4 text-center">
                        Risk
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($risks as $risk)

                <tr class="border-b hover:bg-slate-50">

                    <td class="px-5 py-4 font-bold text-gray-500">

                        #{{ $loop->iteration }}

                    </td>


                    <td class="px-5 py-4">

                        <div class="font-semibold text-slate-800">

                            {{ $risk->country->name }}

                        </div>

                        <div class="text-xs text-gray-400">

                            {{ $risk->country->code }}

                        </div>

                    </td>


                    <td class="px-5 py-4 text-center">

                        {{ $risk->weather_score }}

                    </td>


                    <td class="px-5 py-4 text-center">

                        {{ $risk->inflation_score }}

                    </td>


                    <td class="px-5 py-4 text-center">

                        {{ $risk->currency_score }}

                    </td>


                    <td class="px-5 py-4 text-center">

                        {{ $risk->news_score }}

                    </td>


                    <td class="px-5 py-4 text-center">

                        {{ $risk->port_score }}

                    </td>


                    <td class="px-5 py-4 text-center">

                        <span class="text-xl font-bold text-slate-800">

                            {{ $risk->total_score }}

                        </span>

                    </td>


                    <td class="px-5 py-4 text-center">

                        @if($risk->risk_level === 'HIGH')

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                HIGH
                            </span>

                        @elseif($risk->risk_level === 'MEDIUM')

                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold">
                                MEDIUM
                            </span>

                        @else

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                LOW
                            </span>

                        @endif

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>


{{-- CHART JS --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('riskChart');

    if (!canvas) {
        return;
    }

    const countries = @json($chartCountries);

    const scores = @json($chartScores);

    const colors = scores.map(score => {

        if (score >= 70) {
            return '#ef4444';
        }

        if (score >= 40) {
            return '#f59e0b';
        }

        return '#22c55e';

    });

    new Chart(canvas, {

        type: 'bar',

        data: {

            labels: countries,

            datasets: [

                {

                    label: 'Risk Score',

                    data: scores,

                    backgroundColor: colors,

                    borderRadius: 8,

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    max: 100

                }

            }

        }

    });

});

</script>

@endsection