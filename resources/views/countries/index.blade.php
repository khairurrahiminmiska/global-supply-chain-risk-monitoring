@extends('layouts.main')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h2 class="text-3xl font-bold">
        🌍 Countries
    </h2>

    <form method="GET" action="{{ route('countries.index') }}">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search country..."
            class="border rounded-lg px-4 py-2">

        <button
            class="bg-blue-600 text-white px-4 py-2 rounded-lg">

            Search

        </button>

    </form>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-100">

            <tr>

                <th class="p-4">Flag</th>

                <th class="p-4">Country</th>

                <th class="p-4">Code</th>

                <th class="p-4">Region</th>

                <th class="p-4">Currency</th>

                <th class="p-4">Population</th>

                <th class="p-4">Action</th>

            </tr>

        </thead>

        <tbody>

        @forelse($countries as $country)

            <tr class="border-t">

                <td class="p-3">

                    @if($country->flag)

                        <img src="{{ $country->flag }}" width="40">

                    @endif

                </td>

                <td>{{ $country->name }}</td>

                <td>{{ $country->code }}</td>

                <td>{{ $country->region }}</td>

                <td>{{ $country->currency }}</td>

                <td>{{ number_format($country->population) }}</td>

                <td>

                    <a
                        href="{{ route('countries.show',$country) }}"
                        class="bg-blue-600 text-white px-3 py-2 rounded">

                        Detail

                    </a>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7" class="text-center p-8">

                    Tidak ada data.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<div class="mt-5">

    {{ $countries->links() }}

</div>

@endsection