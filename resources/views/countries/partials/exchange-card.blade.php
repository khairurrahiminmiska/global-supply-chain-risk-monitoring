<div class="bg-white rounded-2xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold">
                Exchange Rate
            </h2>

            <p class="text-gray-500 text-sm">
                Nilai tukar mata uang terbaru
            </p>

        </div>

        <form
            action="{{ route('countries.exchange.sync',$country) }}"
            method="POST"
            data-ajax="true">

            @csrf

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                Update Rate

            </button>

        </form>

    </div>

    @if($exchangeRate)

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-blue-50 rounded-xl p-5">

                <p class="text-gray-500 text-sm">
                    Base Currency
                </p>

                <h2 class="text-3xl font-bold mt-2 text-blue-700">

                    {{ $exchangeRate->base_currency }}

                </h2>

            </div>

            <div class="bg-green-50 rounded-xl p-5">

                <p class="text-gray-500 text-sm">
                    Target Currency
                </p>

                <h2 class="text-3xl font-bold mt-2 text-green-700">

                    {{ $exchangeRate->target_currency }}

                </h2>

            </div>

            <div class="bg-yellow-50 rounded-xl p-5">

                <p class="text-gray-500 text-sm">
                    Last Updated
                </p>

                <h2 class="text-lg font-bold mt-2 text-yellow-700">

                    {{ $exchangeRate->retrieved_at->format('d M Y') }}

                </h2>

                <p class="text-sm mt-1">

                    {{ $exchangeRate->retrieved_at->format('H:i') }}

                </p>

            </div>

        </div>

        <div class="mt-8">

            <p class="text-gray-500 mb-2">

                Current Exchange Rate

            </p>

            <div class="flex items-center gap-4">

                <span class="text-5xl font-bold text-green-600">

                    {{ number_format($exchangeRate->rate,2,',','.') }}

                </span>

                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                    Live

                </span>

            </div>

        </div>

    @else

        <div class="text-center py-10">

            <div class="text-6xl mb-4">

                <span class="text-4xl font-bold text-slate-300">$</span>

            </div>

            <p class="text-gray-500">

                Belum ada data exchange rate.

            </p>

            <p class="text-sm text-gray-400 mt-2">

                Klik tombol "Update Rate" untuk mengambil data terbaru.

            </p>

        </div>

    @endif

</div>