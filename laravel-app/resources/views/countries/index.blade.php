@extends('layouts.main')

@section('content')

@include('partials.nav.country')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-4xl font-bold text-slate-800">
                Countries
            </h1>

            <p class="text-gray-500 mt-2">
                Global Supply Chain Monitoring Countries
            </p>

        </div>

        <div class="flex items-center gap-3">

            <form action="{{ route('countries.sync') }}" method="POST" data-ajax="true">
                @csrf
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-3 rounded-xl shadow-lg">
                    Sync Countries
                </button>
            </form>

            <form action="{{ route('countries.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                <input type="file" name="csv" accept=".csv" required
                       class="text-sm text-slate-500 file:mr-3 file:px-4 file:py-2 file:rounded-xl file:border-0 file:bg-slate-100 file:text-slate-700 file:font-semibold file:cursor-pointer hover:file:bg-slate-200 transition">
                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-semibold transition">
                    Import CSV
                </button>
            </form>

        </div>

    </div>


    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">

        {{-- Search --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-6">

            <form
                action="{{ route('countries.index') }}"
                method="GET"
                class="flex gap-3">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search country..."
                    class="border border-slate-300 rounded-xl px-4 py-3 w-80 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <button
                    class="bg-slate-800 hover:bg-slate-900 text-white px-6 rounded-xl transition">

                    Search

                </button>

            </form>

            <div class="text-gray-500 font-semibold">

                Total :
                <span class="text-blue-600">
                    {{ $countries->total() }}
                </span>

            </div>

        </div>


        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100 text-slate-700">

                    <tr>

                        <th class="px-6 py-4 text-left">Flag</th>
                        <th class="px-6 py-4 text-left">Country</th>
                        <th class="px-6 py-4 text-left">Code</th>
                        <th class="px-6 py-4 text-left">Region</th>
                        <th class="px-6 py-4 text-left">Currency</th>
                        <th class="px-6 py-4 text-right">Population</th>
                        <th class="px-6 py-4 text-center">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($countries as $country)

                    <tr class="border-b hover:bg-slate-50 transition">

                        <td class="px-6 py-4">

                            @if($country->flag)

                                <img
                                    src="{{ $country->flag }}"
                                    class="w-14 h-10 rounded shadow object-cover">

                            @else

                                <div
                                    class="w-14 h-10 rounded bg-slate-200 flex items-center justify-center">

                                    <span class="text-slate-400 font-bold">?</span>

                                </div>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="font-bold text-slate-800">

                                {{ $country->name }}

                            </div>

                        </td>

                        <td class="px-6 py-4">

                            <span class="bg-slate-100 px-3 py-1 rounded-lg">

                                {{ $country->code }}

                            </span>

                        </td>

                        <td class="px-6 py-4">

                            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">

                                {{ $country->region }}

                            </span>

                        </td>

                        <td class="px-6 py-4">

                            <span class="bg-green-50 text-green-700 px-3 py-1 rounded-lg">

                                {{ $country->currency }}

                            </span>

                        </td>

                        <td class="px-6 py-4 text-right font-semibold">

                            {{ number_format($country->population) }}

                        </td>

                        <td class="px-6 py-4 text-center">

                            <a
                                href="{{ route('countries.show',$country) }}"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition shadow">

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center py-14 text-gray-500">

                            Belum ada data negara.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        <div class="mt-8">

            {{ $countries->links() }}

        </div>

    </div>

</div>

@endsection