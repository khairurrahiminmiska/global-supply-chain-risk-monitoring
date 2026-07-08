<div class="bg-white rounded-2xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold">
                📰 News Intelligence
            </h2>

            <p class="text-gray-500 text-sm">
                Logistics • Trade • Shipping • Economy
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
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

                🔄 Update News

            </button>

        </form>

    </div>

    @forelse($news as $item)

        <div class="border rounded-xl p-5 mb-5 hover:shadow-md transition">

            <div class="flex justify-between items-start">

                <div>

                    <span
                        class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">

                        {{ ucfirst(request('category','Economy')) }}

                    </span>

                </div>

                <div class="text-sm text-gray-500">

                    {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}

                </div>

            </div>

            <h3 class="text-xl font-bold mt-4">

                {{ $item->title }}

            </h3>

            <p class="text-gray-600 mt-3 leading-relaxed">

                {{ $item->description }}

            </p>

            <div class="flex justify-between items-center mt-5">

                <div>

                    <span class="text-sm text-gray-500">

                        Source :

                    </span>

                    <span class="font-semibold">

                        {{ $item->source }}

                    </span>

                </div>

                <a
                    href="{{ $item->url }}"
                    target="_blank"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                    Read More →

                </a>

            </div>

        </div>

    @empty

        <div class="text-center py-12">

            <div class="text-6xl mb-4">

                📰

            </div>

            <p class="text-gray-500 text-lg">

                Belum ada berita.

            </p>

            <p class="text-gray-400 mt-2">

                Klik "Update News" untuk mengambil berita terbaru.

            </p>

        </div>

    @endforelse

</div>