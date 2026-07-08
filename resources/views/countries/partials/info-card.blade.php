<div class="bg-white rounded-2xl shadow-lg p-6">

    <div class="flex items-center justify-between">

        <div class="flex items-center gap-5">

            <img
                src="{{ $country->flag }}"
                alt="{{ $country->name }}"
                class="w-24 h-16 object-cover rounded-lg border">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    {{ $country->name }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ $country->code }} • {{ $country->region }}
                </p>

            </div>

        </div>

        <div>

            <a href="{{ route('countries.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg">

                ← Back

            </a>

        </div>

    </div>

    <hr class="my-6">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-blue-50 rounded-xl p-4">

            <p class="text-gray-500 text-sm">

                🏛 Capital

            </p>

            <h3 class="text-xl font-bold mt-2">

                {{ $country->capital ?? '-' }}

            </h3>

        </div>

        <div class="bg-green-50 rounded-xl p-4">

            <p class="text-gray-500 text-sm">

                💱 Currency

            </p>

            <h3 class="text-xl font-bold mt-2">

                {{ $country->currency ?? '-' }}

            </h3>

        </div>

        <div class="bg-yellow-50 rounded-xl p-4">

            <p class="text-gray-500 text-sm">

                👥 Population

            </p>

            <h3 class="text-xl font-bold mt-2">

                {{ number_format($country->population) }}

            </h3>

        </div>

        <div class="bg-purple-50 rounded-xl p-4">

            <p class="text-gray-500 text-sm">

                🌎 Region

            </p>

            <h3 class="text-xl font-bold mt-2">

                {{ $country->region }}

            </h3>

        </div>

    </div>

</div>