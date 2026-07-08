<div class="bg-white rounded-2xl shadow-lg p-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold">
                🌦 Weather Monitoring
            </h2>

            <p class="text-gray-500 text-sm">
                Real Time Weather • Open-Meteo API
            </p>

        </div>

        <form action="{{ route('countries.weather.sync',$country) }}" method="POST">

            @csrf

            <button
                class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg transition">

                🌦 Update Weather

            </button>

        </form>

    </div>

    @if($weather)

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Temperature --}}
            <div class="bg-blue-50 rounded-xl p-5 text-center">

                <div class="text-5xl">
                    🌡️
                </div>

                <p class="text-gray-500 mt-3">
                    Temperature
                </p>

                <h2 class="text-3xl font-bold text-blue-700 mt-2">

                    {{ $weather->temperature }} °C

                </h2>

            </div>

            {{-- Rain --}}
            <div class="bg-cyan-50 rounded-xl p-5 text-center">

                <div class="text-5xl">
                    🌧️
                </div>

                <p class="text-gray-500 mt-3">
                    Rain
                </p>

                <h2 class="text-3xl font-bold text-cyan-700 mt-2">

                    {{ $weather->rain }} mm

                </h2>

            </div>

            {{-- Wind --}}
            <div class="bg-green-50 rounded-xl p-5 text-center">

                <div class="text-5xl">
                    💨
                </div>

                <p class="text-gray-500 mt-3">
                    Wind Speed
                </p>

                <h2 class="text-3xl font-bold text-green-700 mt-2">

                    {{ $weather->wind_speed }} km/h

                </h2>

            </div>

            {{-- Weather Code --}}
            <div class="bg-red-50 rounded-xl p-5 text-center">

                <div class="text-5xl">
                    ⛈️
                </div>

                <p class="text-gray-500 mt-3">
                    Weather Code
                </p>

                <h2 class="text-3xl font-bold text-red-600 mt-2">

                    {{ $weather->weather_code }}

                </h2>

            </div>

        </div>

        <hr class="my-8">

        <div class="bg-slate-50 rounded-xl p-5">

            <div class="grid md:grid-cols-2 gap-5">

                <div>

                    <h3 class="font-bold mb-3">

                        📌 Weather Information

                    </h3>

                    <ul class="space-y-2 text-gray-600">

                        <li>✔ Temperature : {{ $weather->temperature }} °C</li>

                        <li>✔ Rainfall : {{ $weather->rain }} mm</li>

                        <li>✔ Wind Speed : {{ $weather->wind_speed }} km/h</li>

                        <li>✔ Weather Code : {{ $weather->weather_code }}</li>

                    </ul>

                </div>

                <div>

                    <h3 class="font-bold mb-3">

                        🕒 Last Update

                    </h3>

                    <p class="text-lg">

                        {{ $weather->retrieved_at->format('d M Y H:i') }}

                    </p>

                    <p class="text-sm text-gray-500 mt-2">

                        Data diperoleh dari Open-Meteo API secara realtime.

                    </p>

                </div>

            </div>

        </div>

    @else

        <div class="text-center py-14">

            <div class="text-6xl mb-5">
                🌦
            </div>

            <h2 class="text-xl font-bold">

                Belum ada data cuaca

            </h2>

            <p class="text-gray-500 mt-3">

                Klik tombol <b>Update Weather</b> untuk mengambil data terbaru dari Open-Meteo API.

            </p>

        </div>

    @endif

</div>