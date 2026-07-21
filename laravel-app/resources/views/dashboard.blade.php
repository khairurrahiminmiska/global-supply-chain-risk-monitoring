@extends('layouts.main')

@section('content')

<div class="space-y-8">

    {{-- HERO --}}
    <div>

        <h1 class="text-4xl font-bold text-slate-800">
            Global Supply Chain Risk Monitoring
        </h1>

        <p class="text-gray-500 mt-2">
            Monitor countries, exchange rates, weather, economy,
            logistics news and global supply chain risk.
        </p>

    </div>


    {{-- CARD STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- Countries --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-gray-500">
                        Countries
                    </p>

                    <h1 class="text-5xl font-bold text-blue-600 mt-3">

                        {{ $countryCount }}

                    </h1>

                    <p class="text-green-600 text-sm mt-3">

                        ✔ Database Connected

                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl">#</div>

            </div>

        </div>


        {{-- Exchange --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-gray-500">
                        Exchange Rate
                    </p>

                    <h1 class="text-5xl font-bold text-green-600 mt-3">

                        {{ $exchangeRateCount }}

                    </h1>

                    <p class="text-green-600 text-sm mt-3">

                        ✔ Updated

                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 font-bold text-xl">$</div>

            </div>

        </div>


        {{-- News --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-gray-500">

                        News

                    </p>

                    <h1 class="text-5xl font-bold text-yellow-500 mt-3">

                        {{ $newsCount }}

                    </h1>

                    <p class="text-green-600 text-sm mt-3">

                        ✔ Live API

                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 font-bold text-xl">N</div>

            </div>

        </div>


        {{-- GLOBAL RISK --}}

<a
    href="{{ route('risk.analytics') }}"
    class="block bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition"
>

    <div class="flex justify-between">

        <div>

            <p class="text-gray-500">
                Global Risk Score
            </p>

            <h1 class="
                text-5xl font-bold mt-3

                @if($globalRiskLevel === 'HIGH')
                    text-red-500
                @elseif($globalRiskLevel === 'MEDIUM')
                    text-orange-500
                @else
                    text-green-500
                @endif
            ">

                {{ $globalRiskLevel }}

            </h1>

            <p class="text-gray-500 text-sm mt-3">

                Average Score:
                <span class="font-bold text-slate-700">
                    {{ $averageRiskScore }}
                </span>

            </p>

            <div class="flex gap-3 mt-3 text-xs">

                <span class="inline-flex items-center gap-1 text-red-600"><span class="w-2 h-2 rounded-full bg-red-500"></span> {{ $highRiskCount }} High</span>
                <span class="inline-flex items-center gap-1 text-orange-600"><span class="w-2 h-2 rounded-full bg-orange-500"></span> {{ $mediumRiskCount }} Medium</span>
                <span class="inline-flex items-center gap-1 text-green-600"><span class="w-2 h-2 rounded-full bg-green-500"></span> {{ $lowRiskCount }} Low</span>

            </div>

        </div>

        <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xl">%</div>

    </div>

</a>

    </div>


    {{-- CHART DASHBOARD --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <h2 class="font-bold text-xl mb-5">

                GDP Trend

            </h2>

            <canvas id="gdpChart"></canvas>

        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <h2 class="font-bold text-xl mb-5">

                Inflation Trend

            </h2>

            <canvas id="inflationChart"></canvas>

        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <h2 class="font-bold text-xl mb-5">

                Currency Trend

            </h2>

            <canvas id="currencyChart"></canvas>

        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <h2 class="font-bold text-xl mb-5">

                Risk Trend

            </h2>

            <canvas id="riskChart"></canvas>

        </div>

    </div>


    {{-- TABLE + NEWS --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Latest Countries --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <h2 class="text-xl font-bold mb-5">

                Latest Countries

            </h2>

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="py-3 text-left">

                            Country

                        </th>

                        <th class="text-left">

                            Code

                        </th>

                        <th class="text-left">

                            Currency

                        </th>

                    </tr>

                </thead>

                <tbody>

                @foreach($latestCountries as $country)

                    <tr class="border-b hover:bg-slate-50">

                        <td class="py-3">

                            <div class="flex items-center gap-3">

                                @if($country->flag)

                                    <img
                                        src="{{ $country->flag }}"
                                        class="w-8 h-6 rounded shadow">

                                @endif

                                {{ $country->name }}

                            </div>

                        </td>

                        <td>

                            {{ $country->code }}

                        </td>

                        <td>

                            {{ $country->currency }}

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>


        {{-- Latest News --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <h2 class="text-xl font-bold mb-5">

                Latest News

            </h2>

            @forelse($latestNews as $news)

                <div class="border rounded-xl p-4 mb-4 hover:bg-slate-50">

                    <h3 class="font-semibold">

                        {{ $news->title }}

                    </h3>

                    <p class="text-gray-500 mt-2 text-sm">

                        {{ \Illuminate\Support\Str::limit($news->description,120) }}

                    </p>

                    <div class="flex justify-between mt-3 text-sm">

                        <span class="text-blue-600">

                            {{ $news->source }}

                        </span>

                        <span class="text-gray-400">

                            {{ \Carbon\Carbon::parse($news->published_at)->diffForHumans() }}

                        </span>

                    </div>

                </div>

            @empty

                <p class="text-gray-500">

                    Belum ada berita.

                </p>

            @endforelse

        </div>

        </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', async function () {
    try {
        const response = await fetch("{{ route('dashboard.chart') }}");
        const data = await response.json();

        new Chart(document.getElementById('gdpChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'GDP',
                    data: data.gdp
                }]
            }
        });

        new Chart(document.getElementById('inflationChart'), {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Inflation (%)',
                    data: data.inflation,
                    tension: 0.4
                }]
            }
        });

        new Chart(document.getElementById('currencyChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Exchange Rate vs USD',
                    data: data.currency
                }]
            }
        });

        new Chart(document.getElementById('riskChart'), {
            type: 'line',
            data: {
                labels: data.risk_labels,
                datasets: [{
                    label: 'Average Risk Score',
                    data: data.risk,
                    tension: 0.4,
                    fill: false,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Average Risk Score: ' + context.raw;
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

    } catch (error) {
        console.error('Dashboard chart error:', error);
    }
});
</script>

@endsection



