<x-app-layout>

    <x-slot name="header">
        @if(session('success'))

<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">

    {{ session('success') }}

</div>

@endif
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Countries
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-bold mb-4">
                        🌍 Countries List
                    </h3>

                     <form action="{{ route('countries.sync') }}" method="POST">

        @csrf

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

            🔄 Sync Countries

        </button>

    </form>

</div>

                    <table class="table-auto w-full border">

                        <thead class="bg-gray-200">

                            <tr>

                                <th class="border p-2">No</th>
                                <th class="border p-2">Flag</th>
                                <th class="border p-2">Country</th>
                                <th class="border p-2">Capital</th>
                                <th class="border p-2">Region</th>
                                <th class="border p-2">Population</th>

                            </tr>

                        </thead>

                        <tbody>

                        @forelse($countries as $country)

                            <tr>

                                <td class="border p-2">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border p-2">

                                    @if($country->flag)

                                        <img src="{{ $country->flag }}" width="40">

                                    @endif

                                </td>

                                <td class="border p-2">
                                    {{ $country->name }}
                                </td>

                                <td class="border p-2">
                                    {{ $country->capital }}
                                </td>

                                <td class="border p-2">
                                    {{ $country->region }}
                                </td>

                                <td class="border p-2">
                                    {{ number_format($country->population) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="border p-4 text-center">

                                    Belum ada data negara.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>