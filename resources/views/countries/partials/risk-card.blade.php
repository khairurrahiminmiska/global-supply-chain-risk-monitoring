<div class="bg-white rounded-2xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold">

                Risk Score

            </h2>

            <p class="text-gray-500">

                Supply Chain Risk Engine

            </p>

        </div>

        <form
            action="{{ route('countries.risk.calculate',$country) }}"
            method="POST"
            data-ajax="true">

            @csrf

            <button
                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

                Calculate Risk

            </button>

        </form>

    </div>

    @if($risk)

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

            <div class="bg-blue-50 rounded-xl p-5 text-center">

                <h4 class="font-semibold">
                    Weather
                </h4>

                <h1 class="text-4xl font-bold mt-3">

                    {{ $risk->weather_score }}

                </h1>

            </div>

            <div class="bg-yellow-50 rounded-xl p-5 text-center">

                <h4 class="font-semibold">
                    Inflation
                </h4>

                <h1 class="text-4xl font-bold mt-3">

                    {{ $risk->inflation_score }}

                </h1>

            </div>

            <div class="bg-green-50 rounded-xl p-5 text-center">

                <h4 class="font-semibold">
                    Currency
                </h4>

                <h1 class="text-4xl font-bold mt-3">

                    {{ $risk->currency_score }}

                </h1>

            </div>

            <div class="bg-purple-50 rounded-xl p-5 text-center">

                <h4 class="font-semibold">
                    News
                </h4>

                <h1 class="text-4xl font-bold mt-3">

                    {{ $risk->news_score }}

                </h1>

            </div>

        </div>

        <hr class="my-8">

        <div class="text-center">

            <p class="text-gray-500">

                Total Risk Score

            </p>

            <h1 class="text-6xl font-bold mt-3">

                {{ $risk->total_score }}

            </h1>

            @if($risk->risk_level=='LOW')

                <span
                    class="bg-green-100 text-green-700 px-5 py-2 rounded-full">

                    LOW

                </span>

            @elseif($risk->risk_level=='MEDIUM')

                <span
                    class="bg-yellow-100 text-yellow-700 px-5 py-2 rounded-full">

                    MEDIUM

                </span>

            @else

                <span
                    class="bg-red-100 text-red-700 px-5 py-2 rounded-full">

                    HIGH

                </span>

            @endif

        </div>

    @else

        <div class="text-center py-10">

            <div class="text-5xl font-bold text-slate-300">%</div>

            <h2 class="text-xl font-bold mt-5">

                Belum ada Risk Score

            </h2>

            <p class="text-gray-500 mt-3">

                Klik tombol Calculate Risk.

            </p>

        </div>

    @endif

</div>