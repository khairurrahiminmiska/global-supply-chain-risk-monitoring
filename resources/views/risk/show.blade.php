@extends('layouts.main')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

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
            class="px-5 py-3 bg-slate-800 text-white rounded-xl hover:bg-slate-700"
        >
            ← Back to Risk Score
        </a>

    </div>


    {{-- CURRENT RISK --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500">
                Country
            </p>

            <h2 class="text-2xl font-bold mt-3">
                {{ $riskScore->country?->name ?? 'Unknown' }}
            </h2>

        </div>


        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500">
                Current Risk Score
            </p>

            <h2 class="text-4xl font-bold mt-3">
                {{ $riskScore->total_score }}
            </h2>

        </div>


        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500">
                Risk Level
            </p>

            <div class="mt-4">

                @if($riskScore->risk_level === 'HIGH')

                    <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold">
                        HIGH
                    </span>

                @elseif($riskScore->risk_level === 'MEDIUM')

                    <span class="px-4 py-2 rounded-full bg-orange-100 text-orange-700 font-bold">
                        MEDIUM
                    </span>

                @else

                    <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold">
                        LOW
                    </span>

                @endif

            </div>

        </div>


        <div class="bg-white rounded-2xl shadow-lg p-6">

            <p class="text-gray-500">
                History Records
            </p>

            <h2 class="text-4xl font-bold mt-3">
                {{ $riskHistories->count() }}
            </h2>

        </div>

    </div>


    {{-- RISK TREND --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">

        <h2 class="text-xl font-bold text-slate-800 mb-5">
            📈 Risk Score Trend
        </h2>

        <div class="h-[400px]">
            <canvas id="riskHistoryChart"></canvas>
        </div>

    </div>


    {{-- HISTORY TABLE --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="p-6 border-b">

            <h2 class="text-xl font-bold text-slate-800">
                Risk Calculation History
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>
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

                        <tr class="border-b hover:bg-slate-50">

                            <td class="px-5 py-4">
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

                            <td class="px-5 py-4 text-center font-bold">
                                {{ $history->total_score }}
                            </td>

                            <td class="px-5 py-4 text-center">

                                @if($history->risk_level === 'HIGH')

                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                                        HIGH
                                    </span>

                                @elseif($history->risk_level === 'MEDIUM')

                                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 font-semibold">
                                        MEDIUM
                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                                        LOW
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="8"
                                class="p-10 text-center text-gray-500"
                            >
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

<script>

document.addEventListener('DOMContentLoaded', function () {

    const labels = @json($chartLabels);

    const scores = @json($chartScores);

    const canvas = document.getElementById('riskHistoryChart');

    new Chart(canvas, {

        type: 'line',

        data: {

            labels: labels,

            datasets: [{

                label: 'Risk Score',

                data: scores,

                tension: 0.4,

                fill: false,

                pointRadius: 6,

                pointHoverRadius: 8

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return 'Risk Score: ' + context.raw;

                        }

                    }

                }

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

});

</script>

@endsection