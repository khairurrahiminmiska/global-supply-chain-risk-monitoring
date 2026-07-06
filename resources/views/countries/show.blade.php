@extends('layouts.main')

@section('content')

<div class="mb-6">
    <a href="{{ route('countries.index') }}"
       class="text-blue-600 hover:underline">
        ← Kembali ke Daftar Negara
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex items-center gap-6">

        @if($country->flag)
            <img src="{{ $country->flag }}"
                 alt="{{ $country->name }}"
                 class="w-28 border rounded">
        @endif

        <div>

            <h1 class="text-3xl font-bold">
                {{ $country->name }}
            </h1>

            <p class="text-gray-500">
                {{ $country->code }}
            </p>

        </div>

    </div>

    <hr class="my-6">

    <div class="grid grid-cols-2 gap-6">

        <div>

            <h3 class="font-semibold text-gray-600">
                Capital
            </h3>

            <p>{{ $country->capital ?: '-' }}</p>

        </div>

        <div>

            <h3 class="font-semibold text-gray-600">
                Region
            </h3>

            <p>{{ $country->region }}</p>

        </div>

        <div>

            <h3 class="font-semibold text-gray-600">
                Currency
            </h3>

            <p>{{ $country->currency ?: '-' }}</p>

        </div>

        <div>

            <h3 class="font-semibold text-gray-600">
                Population
            </h3>

            <p>{{ number_format($country->population) }}</p>

        </div>

    </div>

</div>

{{-- Placeholder untuk modul berikutnya --}}
<div class="grid grid-cols-2 gap-6 mt-8">

    <div class="bg-white rounded-xl shadow p-5">

    <div class="flex justify-between items-center mb-4">

        <h2 class="text-xl font-bold">
            💱 Exchange Rate
        </h2>

        <form action="{{ route('countries.exchange.sync',$country) }}" method="POST">

            @csrf

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                Update Rate

            </button>

        </form>

    </div>

    @if($exchangeRate)

        <div class="space-y-2">

            <p>

                <strong>Base Currency :</strong>

                {{ $exchangeRate->base_currency }}

            </p>

            <p>

                <strong>Target Currency :</strong>

                {{ $exchangeRate->target_currency }}

            </p>

            <p>

                <strong>Rate :</strong>

                {{ number_format($exchangeRate->rate,2) }}

            </p>

            <p>

                <strong>Last Update :</strong>

                {{ $exchangeRate->retrieved_at }}

            </p>

        </div>

    @else

        <p class="text-gray-500">

            Belum ada data exchange rate.

        </p>

    @endif

</div>

    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="text-lg font-bold mb-3">📰 News</h2>
        <p class="text-gray-500">Belum diintegrasikan.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="text-lg font-bold mb-3">🌦 Weather</h2>
        <p class="text-gray-500">Belum diintegrasikan.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="text-lg font-bold mb-3">📈 Risk Score</h2>
        <p class="text-gray-500">Belum diintegrasikan.</p>
    </div>

</div>

@endsection