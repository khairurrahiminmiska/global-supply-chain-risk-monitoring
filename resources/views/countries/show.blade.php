@extends('layouts.main')

@section('content')

<div class="mb-6">
    <a href="{{ route('countries.index') }}"
       class="text-blue-600 hover:underline">
        ← Kembali ke Daftar Negara
    </a>
</div>

<<div class="bg-white rounded-xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold">
                💱 Exchange Rate
            </h2>

            <p class="text-gray-500 text-sm">
                Nilai tukar mata uang terbaru
            </p>

        </div>

        <form action="{{ route('countries.exchange.sync',$country) }}" method="POST">

            @csrf

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                🔄 Update Rate

            </button>

        </form>

    </div>

    @if($exchangeRate)

        <div class="grid grid-cols-2 gap-6">

            <div>

                <p class="text-gray-500">
                    Base Currency
                </p>

                <h2 class="text-3xl font-bold">
                    {{ $exchangeRate->base_currency }}
                </h2>

            </div>

            <div>

                <p class="text-gray-500">
                    Target Currency
                </p>

                <h2 class="text-3xl font-bold">
                    {{ $exchangeRate->target_currency }}
                </h2>

            </div>

        </div>

        <hr class="my-6">

        <div>

            <p class="text-gray-500">
                Current Exchange Rate
            </p>

            <h1 class="text-5xl font-bold text-green-600 mt-2">

                {{ number_format($exchangeRate->rate,2,',','.') }}

            </h1>

        </div>

        <div class="mt-6 text-sm text-gray-500">

            Last Updated

            <br>

            {{ $exchangeRate->retrieved_at->format('d M Y H:i') }}

        </div>

    @else

        <div class="text-center py-8">

            <p class="text-gray-500">

                Belum ada data exchange rate.

            </p>

        </div>

    @endif

</div>

    <div class="bg-white rounded-xl shadow-lg p-6 mt-6">

    <div class="flex justify-between items-center mb-5">

        <div>
            <h2 class="text-2xl font-bold">
                📰 Latest News
            </h2>

            <p class="text-gray-500 text-sm">
                Berita terbaru terkait negara ini
            </p>
        </div>

        <form
    action="{{ route('countries.news.sync',$country) }}"
    method="POST"
    class="flex gap-3">

    @csrf

    <select
        name="category"
        class="border rounded-lg px-4 py-2">

        <option value="logistics">
            🚚 Logistics
        </option>

        <option value="trade">
            🌍 Trade
        </option>

        <option value="shipping">
            🚢 Shipping
        </option>

        <option value="economy" selected>
            💰 Economy
        </option>

    </select>

    <button
        class="bg-green-600 text-white px-5 rounded-lg">

        🔄 Update News

    </button>

</form>

    </div>

    @forelse($news as $item)

        <div class="border rounded-lg p-4 mb-4">

            <h3 class="text-lg font-bold">
                {{ $item->title }}
            </h3>

            <p class="text-gray-600 mt-2">
                {{ $item->description }}
            </p>

            <div class="flex justify-between mt-4 text-sm text-gray-500">

                <span>

                    {{ $item->source }}

                </span>

                <span>

                    {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y H:i') }}

                </span>

            </div>

            <a
                href="{{ $item->url }}"
                target="_blank"
                class="inline-block mt-4 text-blue-600 hover:underline">

                Baca Selengkapnya →

            </a>

        </div>

    @empty

        <div class="text-center py-6 text-gray-500">

            Belum ada berita.

        </div>

    @endforelse

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