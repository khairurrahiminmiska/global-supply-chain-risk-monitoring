@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2 class="fw-bold">
                📊 Business Intelligence Dashboard
            </h2>

            <p class="text-muted">
                Global Supply Chain Analytics
            </p>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    GDP Trend

                </div>

                <div class="card-body">

                    <canvas id="gdpChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    Inflation Trend

                </div>

                <div class="card-body">

                    <canvas id="inflationChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    Currency Trend

                </div>

                <div class="card-body">

                    <canvas id="currencyChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    Risk Trend

                </div>

                <div class="card-body">

                    <canvas id="riskChart"></canvas>

                </div>

            </div>

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

            datasets: [

                {

                    label: 'GDP',

                    data: chartData.gdp,

                    borderWidth: 1

                }

            ]

        }

    }
);

</script>

@endsection