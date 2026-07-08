<div class="bg-white rounded-2xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold">

                🌍 Economy

            </h2>

            <p class="text-gray-500 text-sm">

                World Bank Economic Indicators

            </p>

        </div>

        <form
            action="{{ route('countries.economy',$country) }}"
            method="POST">

            @csrf

            <button
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">

                🔄 Update Economy

            </button>

        </form>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <!-- GDP -->

        <div class="bg-blue-50 rounded-xl p-5">

            <p class="text-sm text-gray-500">

                💰 GDP

            </p>

            <h2 class="text-2xl font-bold text-blue-700 mt-3">

                @if($country->gdp)

                    ${{ number_format($country->gdp,0,'.',',') }}

                @else

                    -

                @endif

            </h2>

        </div>

        <!-- Inflation -->

        <div class="bg-red-50 rounded-xl p-5">

            <p class="text-sm text-gray-500">

                📉 Inflation

            </p>

            <h2 class="text-2xl font-bold text-red-600 mt-3">

                @if($country->inflation)

                    {{ number_format($country->inflation,2) }} %

                @else

                    -

                @endif

            </h2>

        </div>

        <!-- Export -->

        <div class="bg-green-50 rounded-xl p-5">

            <p class="text-sm text-gray-500">

                📦 Export

            </p>

            <h2 class="text-2xl font-bold text-green-600 mt-3">

                @if($country->exports)

                    ${{ number_format($country->exports,0,'.',',') }}

                @else

                    Coming Soon

                @endif

            </h2>

        </div>

        <!-- Import -->

        <div class="bg-yellow-50 rounded-xl p-5">

            <p class="text-sm text-gray-500">

                📥 Import

            </p>

            <h2 class="text-2xl font-bold text-yellow-600 mt-3">

                @if($country->imports)

                    ${{ number_format($country->imports,0,'.',',') }}

                @else

                    Coming Soon

                @endif

            </h2>

        </div>

    </div>

    <hr class="my-8">

    <div class="grid md:grid-cols-2 gap-5">

        <div class="bg-gray-50 rounded-xl p-5">

            <h3 class="font-bold mb-2">

                📊 Economic Summary

            </h3>

            <ul class="space-y-2 text-gray-600">

                <li>

                    GDP berasal dari World Bank API.

                </li>

                <li>

                    Inflation merupakan data CPI tahunan.

                </li>

                <li>

                    Export & Import akan ditambahkan pada tahap berikutnya.

                </li>

            </ul>

        </div>

        <div class="bg-indigo-50 rounded-xl p-5">

            <h3 class="font-bold mb-2">

                📌 Status

            </h3>

            <div class="space-y-2">

                <span
                    class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full">

                    ✔ GDP

                </span>

                <span
                    class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full">

                    ✔ Inflation

                </span>

                <span
                    class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                    Export Coming Soon

                </span>

                <span
                    class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                    Import Coming Soon

                </span>

            </div>

        </div>

    </div>

</div>