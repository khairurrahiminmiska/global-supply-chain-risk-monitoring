@extends('layouts.main')

@section('content')

@include('partials.nav.infrastructure')

<div class="space-y-8">

    <div>
        <h2 class="text-2xl font-bold text-slate-800">
            Business Intelligence Dashboard
        </h2>
        <p class="text-gray-500 mt-2">
            Global Supply Chain Analytics
        </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold text-slate-800 mb-5">GDP Trend</h3>
            <canvas id="gdpChart"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold text-slate-800 mb-5">Inflation Trend</h3>
            <canvas id="inflationChart"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold text-slate-800 mb-5">Currency Trend</h3>
            <canvas id="currencyChart"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold text-slate-800 mb-5">Risk Trend</h3>
            <canvas id="riskChart"></canvas>
        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const chartData = @json($chartData);

new Chart(
    document.getElementById('gdpChart'),
    {
        type: 'bar',
        data: {
            labels: chartData.countries,
            datasets: [{
                label: 'GDP (USD)',
                data: chartData.gdp,
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: '#3b82f6',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    }
);

new Chart(
    document.getElementById('inflationChart'),
    {
        type: 'bar',
        data: {
            labels: chartData.countries,
            datasets: [{
                label: 'Inflation (%)',
                data: chartData.inflation,
                backgroundColor: 'rgba(239, 68, 68, 0.6)',
                borderColor: '#ef4444',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    }
);

new Chart(
    document.getElementById('currencyChart'),
    {
        type: 'line',
        data: {
            labels: chartData.countries,
            datasets: [{
                label: 'Exchange Rate (vs USD)',
                data: chartData.currency,
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
                borderColor: '#10b981',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    }
);

new Chart(
    document.getElementById('riskChart'),
    {
        type: 'radar',
        data: {
            labels: chartData.countries,
            datasets: [{
                label: 'Risk Score',
                data: chartData.risk,
                backgroundColor: 'rgba(139, 92, 246, 0.2)',
                borderColor: '#8b5cf6',
                borderWidth: 2,
                pointBackgroundColor: '#8b5cf6'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { stepSize: 20 }
                }
            }
        }
    }
);

</script>

@endsection