@extends('layouts.main')

@section('content')

@include('partials.nav.infrastructure')

{{-- LEAFLET CSS --}}
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

{{-- HEADER --}}
<div class="mb-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Global Ports
            </h1>

            <p class="text-gray-500 mt-2">
                World Port Monitoring and Global Supply Chain Infrastructure
            </p>
        </div>

        <div class="bg-blue-50 border border-blue-100 px-5 py-3 rounded-xl">
            <p class="text-xs text-gray-500">
                Available Ports
            </p>

            <p class="text-2xl font-bold text-blue-600">
                {{ $mapPorts->count() }}
            </p>
        </div>

    </div>

</div>


{{-- MAP CARD --}}
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">

        <div>
            <h2 class="text-xl font-bold text-slate-800">
                🗺️ Global Port Map
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Click a marker to view port information
            </p>
        </div>

        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-semibold">
            ● Interactive Map
        </div>

    </div>

    <div
        id="portMap"
        class="w-full rounded-xl overflow-hidden border border-slate-200"
        style="
            width: 100%;
            height: 550px;
            min-height: 550px;
            position: relative;
            z-index: 1;
        ">
    </div>

</div>


{{-- FILTER --}}
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">

    <div class="mb-5">

        <h2 class="text-lg font-bold text-slate-800">
            🔍 Search & Filter Ports
        </h2>

        <p class="text-gray-500 text-sm mt-1">
            Search ports by name or filter by country
        </p>

    </div>

    <form
        method="GET"
        action="{{ route('ports.index') }}"
        class="flex flex-col lg:flex-row gap-4">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search port name..."
            class="border border-slate-300 rounded-lg px-4 py-3 flex-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

        <select
            name="country"
            class="border border-slate-300 rounded-lg px-4 py-3 lg:w-72 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

            <option value="">
                🌍 All Countries
            </option>

            @foreach($countries as $country)

                <option
                    value="{{ $country->id }}"
                    @selected(request('country') == $country->id)>

                    {{ $country->name }}

                </option>

            @endforeach

        </select>

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-7 py-3 rounded-lg transition">

            🔍 Search

        </button>

        <a
            href="{{ route('ports.index') }}"
            class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-7 py-3 rounded-lg text-center transition">

            Reset

        </a>

    </form>


    @if(request('search') || request('country'))

        <div class="mt-5 bg-blue-50 border border-blue-100 rounded-lg px-4 py-3">

            <p class="text-blue-700 text-sm">

                Found

                <strong>
                    {{ $mapPorts->count() }}
                </strong>

                port(s) matching the current filter.

            </p>

        </div>

    @endif

</div>


{{-- PORT IMPORT --}}
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                📥 Import Ports from CSV
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                Upload a CSV file with port data to bulk import into the system.
            </p>
        </div>
        <form
            method="POST"
            action="{{ route('ports.import') }}"
            enctype="multipart/form-data"
            class="flex flex-col sm:flex-row gap-3 items-start sm:items-center"
        >
            @csrf
            <input
                type="file"
                name="csv"
                accept=".csv"
                required
                class="border border-slate-300 rounded-lg px-4 py-2.5 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold hover:file:bg-blue-100"
            >
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition"
            >
                Upload & Import
            </button>
        </form>
    </div>
</div>

{{-- PORT DATABASE --}}
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">

    <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

        <div>

            <h2 class="text-xl font-bold text-slate-800">
                🚢 Port Database
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Global port infrastructure database
            </p>

        </div>

        <div class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-sm">

            Total:
            <strong>
                {{ $ports->total() }}
            </strong>

        </div>

    </div>


    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-slate-100">

                <tr class="text-slate-600 text-sm">

                    <th class="px-6 py-4 text-left">
                        Port
                    </th>

                    <th class="px-6 py-4 text-left">
                        Country
                    </th>

                    <th class="px-6 py-4 text-left">
                        Type
                    </th>

                    <th class="px-6 py-4 text-left">
                        Size
                    </th>

                    <th class="px-6 py-4 text-left">
                        Latitude
                    </th>

                    <th class="px-6 py-4 text-left">
                        Longitude
                    </th>

                    <th class="px-6 py-4 text-center">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($ports as $port)

                    <tr class="hover:bg-blue-50/50 transition">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    ⚓
                                </div>

                                <div>

                                    <p class="font-semibold text-slate-800">
                                        {{ $port->name }}
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        {{ $port->wpi_number ?? 'Port Infrastructure' }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-5 text-slate-600">

                            {{ $port->country?->name ?? '-' }}

                        </td>

                        <td class="px-6 py-5 text-slate-600">

                            {{ $port->harbor_type ?? $port->type ?? '-' }}

                        </td>

                        <td class="px-6 py-5">

                            <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-lg text-sm">

                                {{ $port->harbor_size ?? '-' }}

                            </span>

                        </td>

                        <td class="px-6 py-5 text-slate-500 text-sm">

                            {{ $port->latitude }}

                        </td>

                        <td class="px-6 py-5 text-slate-500 text-sm">

                            {{ $port->longitude }}

                        </td>

                        <td class="px-6 py-5 text-center">

                            <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>

                                {{ $port->status }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-16">

                            <div class="text-5xl mb-4">
                                🚢
                            </div>

                            <h3 class="font-bold text-slate-700">
                                Port Not Found
                            </h3>

                            <p class="text-gray-500 mt-2">
                                No ports match the current search filter.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="p-6 border-t border-slate-100">

        {{ $ports->links() }}

    </div>

</div>


{{-- LEAFLET JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const mapElement = document.getElementById('portMap');

    if (!mapElement) {
        return;
    }


    const ports = {{ Illuminate\Support\Js::from($mapPorts) }};
    const targetPorts = {{ Illuminate\Support\Js::from($targetPorts) }};


    const map = L.map('portMap', {
        center: [20, 0],
        zoom: 2,
        scrollWheelZoom: true
    });


    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }
    ).addTo(map);


    const markers = [];


    ports.forEach(function (port) {

        const latitude = parseFloat(port.latitude);
        const longitude = parseFloat(port.longitude);


        if (
            Number.isNaN(latitude) ||
            Number.isNaN(longitude)
        ) {
            return;
        }


        const marker = L.marker([
            latitude,
            longitude
        ]).addTo(map);


        const country = port.country
            ? port.country.name
            : '-';


        marker.bindPopup(`

            <div style="min-width: 230px;">

                <div style="
                    font-size: 18px;
                    font-weight: 700;
                    margin-bottom: 10px;
                ">
                    🚢 ${port.name}
                </div>

                <hr style="
                    margin-top: 8px;
                    margin-bottom: 10px;
                ">

                <p style="margin: 6px 0;">
                    🌍 <b>Country:</b> ${country}
                </p>

                <p style="margin: 6px 0;">
                    ⚓ <b>Harbor Type:</b>
                    ${port.harbor_type ?? port.type ?? '-'}
                </p>

                <p style="margin: 6px 0;">
                    📦 <b>Harbor Size:</b>
                    ${port.harbor_size ?? '-'}
                </p>

                <p style="margin: 6px 0;">
                    📍 <b>Latitude:</b> ${latitude}
                </p>

                <p style="margin: 6px 0;">
                    📍 <b>Longitude:</b> ${longitude}
                </p>

                <p style="margin: 6px 0;">
                    🟢 <b>Status:</b>
                    ${port.status ?? '-'}
                </p>

            </div>

        `);


        markers.push(marker);

    });


    setTimeout(function () {

    map.invalidateSize();

    if (targetPorts.length === 1) {

        const target = targetPorts[0];

        const latitude = parseFloat(target.latitude);
        const longitude = parseFloat(target.longitude);

        map.setView(
            [latitude, longitude],
            13
        );

        markers.forEach(function (marker) {

            const position = marker.getLatLng();

            if (
                Math.abs(position.lat - latitude) < 0.000001 &&
                Math.abs(position.lng - longitude) < 0.000001
            ) {
                marker.openPopup();
            }

        });

    }

    else if (targetPorts.length > 1) {

        const bounds = targetPorts.map(function (port) {

            return [
                parseFloat(port.latitude),
                parseFloat(port.longitude)
            ];

        });

        map.fitBounds(
            bounds,
            {
                padding: [50, 50],
                maxZoom: 7
            }
        );

    }

    else if (markers.length > 0) {

        const markerGroup = L.featureGroup(markers);

        map.fitBounds(
            markerGroup.getBounds(),
            {
                padding: [50, 50],
                maxZoom: 3
            }
        );

    }

}, 300);

});

</script>

@endsection