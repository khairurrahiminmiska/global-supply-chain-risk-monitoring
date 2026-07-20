@extends('layouts.main')

@section('content')

@include('partials.nav.risk')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Risk History
            </h1>

            <p class="text-gray-500 mt-2">
                {{ $riskScore->country?->name ?? 'Unknown Country' }}
                supply chain risk monitoring
            </p>
        </div>

        <a
            href="{{ route('risk.index') }}"
            class="inline-flex items-center justify-center px-5 py-3 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition"
        >
            ← Back to Risk Score
        </a>

    </div>


    {{-- CURRENT RISK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500">
                Country
            </p>

            <h2 class="text-2xl font-bold text-slate-800 mt-3">
                {{ $riskScore->country?->name ?? 'Unknown' }}
            </h2>

            <p class="text-sm text-gray-400 mt-2">
                {{ $riskScore->country?->code ?? '-' }}
            </p>

        </div>


        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500">
                Current Risk Score
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-3">
                {{ $riskScore->total_score }}
            </h2>

            <p class="text-sm text-gray-400 mt-2">
                Maximum score 100
            </p>

        </div>


        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500">
                Risk Level
            </p>

            <div class="mt-5">

                @if($riskScore->risk_level === 'HIGH')

                    <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold">
                        HIGH
                    </span>

                @elseif($riskScore->risk_level === 'MEDIUM')

                    <span class="inline-flex px-4 py-2 rounded-full bg-orange-100 text-orange-700 font-bold">
                        MEDIUM
                    </span>

                @else

                    <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold">
                        LOW
                    </span>

                @endif

            </div>

        </div>


        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500">
                History Records
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-3">
                {{ $riskHistories->count() }}
            </h2>

            <p class="text-sm text-gray-400 mt-2">
                Risk calculations recorded
            </p>

        </div>

    </div>


    {{-- RISK SCORE TREND --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">

        <div class="mb-5">

            <h2 class="text-xl font-bold text-slate-800">
                Risk Score Trend
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Historical total supply chain risk score.
            </p>

        </div>

        <div class="h-[400px]">
            <canvas id="riskHistoryChart"></canvas>
        </div>

    </div>


    {{-- RISK INDICATOR TREND --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">

        <div class="mb-5">

            <h2 class="text-xl font-bold text-slate-800">
                Risk Indicator Trend
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Historical comparison of weather, inflation, currency,
                news sentiment and port infrastructure risk.
            </p>

        </div>

        <div class="h-[450px]">
            <canvas id="riskIndicatorChart"></canvas>
        </div>

    </div>
    
    {{-- RISK RECOMMENDATIONS --}}
<div class="bg-white rounded-2xl shadow-lg p-6">

    <div class="mb-6">

        <h2 class="text-xl font-bold text-slate-800">
            Risk Mitigation Recommendations
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Automated mitigation recommendations based on
            current supply chain risk indicators.
        </p>

    </div>

    @if(count($recommendations) > 0)

        <div class="space-y-4">

            @foreach($recommendations as $recommendation)

                <div
                    class="border rounded-2xl p-5
                    @if($recommendation['level'] === 'HIGH')
                        border-red-200 bg-red-50
                    @elseif($recommendation['level'] === 'MEDIUM')
                        border-orange-200 bg-orange-50
                    @else
                        border-green-200 bg-green-50
                    @endif"
                >

                    <div
                        class="flex flex-col md:flex-row
                        md:items-center md:justify-between gap-3"
                    >

                        <div>

                            <h3 class="font-bold text-lg text-slate-800">
                                {{ $recommendation['indicator'] }}
                            </h3>

                            <p class="text-gray-600 mt-2">
                                {{ $recommendation['recommendation'] }}
                            </p>

                        </div>

                        <div>

                            @if($recommendation['level'] === 'HIGH')

                                <span
                                    class="inline-flex px-4 py-2
                                    rounded-full bg-red-100
                                    text-red-700 font-bold"
                                >
                                    HIGH PRIORITY
                                </span>

                            @elseif($recommendation['level'] === 'MEDIUM')

                                <span
                                    class="inline-flex px-4 py-2
                                    rounded-full bg-orange-100
                                    text-orange-700 font-bold"
                                >
                                    MEDIUM PRIORITY
                                </span>

                            @else

                                <span
                                    class="inline-flex px-4 py-2
                                    rounded-full bg-green-100
                                    text-green-700 font-bold"
                                >
                                    LOW PRIORITY
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div
            class="border border-green-200
            bg-green-50 rounded-2xl p-6"
        >

            <h3 class="font-bold text-green-700">
                No Critical Risk Recommendations
            </h3>

            <p class="text-green-600 mt-2">
                Current risk indicators are within acceptable levels.
                Continue monitoring supply chain conditions.
            </p>

        </div>

    @endif

</div>

    {{-- HISTORY TABLE --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="p-6 border-b">

            <h2 class="text-xl font-bold text-slate-800">
                Risk Calculation History
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Complete historical risk calculation records.
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr class="text-sm text-slate-600">

                        <th class="px-5 py-4 text-left">
                            Calculation Time
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
                            Risk Level
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($riskHistories->reverse() as $history)

                        <tr class="border-b hover:bg-slate-50 transition">

                            <td class="px-5 py-4 whitespace-nowrap">

                                {{ $history->calculated_at?->format('d M Y H:i:s') ?? '-' }}

                            </td>


                            <td class="px-5 py-4 text-center">

                                {{ $history->weather_score }}

                            </td>


                            <td class="px-5 py-4 text-center">

                                {{ $history->inflation_score }}

                            </td>


                            <td class="px-5 py-4 text-center">

                                {{ $history->currency_score }}

                            </td>


                            <td class="px-5 py-4 text-center">

                                {{ $history->news_score }}

                            </td>


                            <td class="px-5 py-4 text-center">

                                {{ $history->port_score }}

                            </td>


                            <td class="px-5 py-4 text-center">

                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100">

                                    <span class="text-lg font-bold text-slate-800">

                                        {{ $history->total_score }}

                                    </span>

                                </div>

                            </td>


                            <td class="px-5 py-4 text-center">

                                @if($history->risk_level === 'HIGH')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                        HIGH
                                    </span>

                                @elseif($history->risk_level === 'MEDIUM')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-orange-100 text-orange-700 font-semibold">
                        MEDIUM
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                                        LOW
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="p-12 text-center text-gray-500"
                            >

                                <div class="text-4xl mb-3">
                                    📊
                                </div>

                                Risk history data not found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
$indicatorData = $riskHistories->map(function ($history) {
    return [
        'weather' => $history->weather_score,
        'inflation' => $history->inflation_score,
        'currency' => $history->currency_score,
        'news' => $history->news_score,
        'port' => $history->port_score,
    ];
})->values();
@endphp

<script>
document.addEventListener('DOMContentLoaded', function () {

    const chartLabels = @json($chartLabels);
    const chartScores = @json($chartScores);
    const indicatorData = @json($indicatorData);

    const riskHistoryCanvas = document.getElementById('riskHistoryChart');

    if (riskHistoryCanvas) {

        new Chart(riskHistoryCanvas, {
            type: 'line',

            data: {
                labels: chartLabels,

                datasets: [{
                    label: 'Risk Score',
                    data: chartScores,
                    borderColor: 'rgb(37, 99, 235)',
                    backgroundColor: 'rgba(37, 99, 235, 0.10)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    mode: 'index',
                    intersect: false
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,

                        title: {
                            display: true,
                            text: 'Risk Score'
                        }
                    },

                    x: {
                        title: {
                            display: true,
                            text: 'Calculation Time'
                        }
                    }
                }
            }
        });

    }


    const indicatorCanvas = document.getElementById('riskIndicatorChart');

    if (indicatorCanvas) {

        new Chart(indicatorCanvas, {
            type: 'line',

            data: {
                labels: chartLabels,

                datasets: [
                    {
                        label: 'Weather',
                        data: indicatorData.map(item => item.weather),
                        borderColor: 'rgb(14, 165, 233)',
                        tension: 0.4,
                        pointRadius: 4
                    },
                    {
                        label: 'Inflation',
                        data: indicatorData.map(item => item.inflation),
                        borderColor: 'rgb(249, 115, 22)',
                        tension: 0.4,
                        pointRadius: 4
                    },
                    {
                        label: 'Currency',
                        data: indicatorData.map(item => item.currency),
                        borderColor: 'rgb(139, 92, 246)',
                        tension: 0.4,
                        pointRadius: 4
                    },
                    {
                        label: 'News',
                        data: indicatorData.map(item => item.news),
                        borderColor: 'rgb(239, 68, 68)',
                        tension: 0.4,
                        pointRadius: 4
                    },
                    {
                        label: 'Port',
                        data: indicatorData.map(item => item.port),
                        borderColor: 'rgb(22, 163, 74)',
                        tension: 0.4,
                        pointRadius: 4
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    mode: 'index',
                    intersect: false
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,

                        title: {
                            display: true,
                            text: 'Indicator Risk Score'
                        }
                    },

                    x: {
                        title: {
                            display: true,
                            text: 'Calculation Time'
                        }
                    }
                }
            }
        });

    }

});
</script>

@endsection