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

        <div class="flex items-center gap-3">

            @if($watchlist)

                <form action="{{ route('watchlist.destroy', $watchlist) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg font-semibold transition text-sm">
                        Remove from Watchlist
                    </button>
                </form>

            @else

                <form action="{{ route('watchlist.store', $country) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg font-semibold transition text-sm">
                        Add to Watchlist
                    </button>
                </form>

            @endif

            <a href="{{ route('countries.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg text-sm">
                Back
            </a>

        </div>

    </div>

    <hr class="my-6">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-blue-50 rounded-xl p-4">

            <p class="text-gray-500 text-sm">

                Capital

            </p>

            <h3 class="text-xl font-bold mt-2">

                {{ $country->capital ?? '-' }}

            </h3>

        </div>

        <div class="bg-green-50 rounded-xl p-4">

            <p class="text-gray-500 text-sm">

                Currency

            </p>

            <h3 class="text-xl font-bold mt-2">

                {{ $country->currency ?? '-' }}

            </h3>

        </div>

        <div class="bg-yellow-50 rounded-xl p-4">

            <p class="text-gray-500 text-sm">

                Population

            </p>

            <h3 class="text-xl font-bold mt-2">

                @php
                    $p = $country->population;
                    if ($p >= 1e9) $pfmt = number_format($p/1e9,2).'B';
                    elseif ($p >= 1e6) $pfmt = number_format($p/1e6,2).'M';
                    elseif ($p >= 1e3) $pfmt = number_format($p/1e3,2).'K';
                    else $pfmt = number_format($p);
                @endphp
                <span class="break-all">{{ $pfmt }}</span>

            </h3>

        </div>

        <div class="bg-purple-50 rounded-xl p-4">

            <p class="text-gray-500 text-sm">

                Region

            </p>

            <h3 class="text-xl font-bold mt-2">

                {{ $country->region }}

            </h3>

        </div>

    </div>

</div>