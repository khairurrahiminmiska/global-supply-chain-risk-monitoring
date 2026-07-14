@extends('layouts.main')

@section('content')

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<style>
    #riskMap {
        height: 620px;
        width: 100%;
        z-index: 1;
    }

    .risk-marker {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 14px;
        color: white;
        font-size: 12px;
        font-weight: 800;
        border: 4px solid rgba(255, 255, 255, 0.95);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.20);
        transition: 0.25s ease;
    }

    .risk-marker:hover {
        transform: scale(1.12);
    }

    .risk-low {
        background: #16a34a;
    }

    .risk-medium {
        background: #f59e0b;
    }

    .risk-high {
        background: #dc2626;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 20px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18);
    }

    .leaflet-popup-content {
        margin: 0;
        width: 320px !important;
    }

    .leaflet-popup-tip {
        box-shadow: none;
    }
</style>

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                GLOBAL RISK INTELLIGENCE
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-slate-900">
                Global Supply Chain Risk Map
            </h1>

            <p class="text-slate-500 mt-3 max-w-2xl">
                Interactive geographical monitoring of country supply chain
                risks based on weather, inflation, currency, news sentiment
                and port infrastructure.
            </p>
        </div>

        <a
            href="{{ route('risk.index') }}"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition shadow-sm"
        >
            <span>📈</span>
            Risk Score
        </a>

    </div>


    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Monitored Countries
                    </p>

                    <h2 class="text-3xl font-bold text-slate-900 mt-2">
                        {{ $summary['total'] }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-xl">
                    🌍
                </div>
            </div>
        </div>

        <div class="bg-white border border-emerald-100 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Low Risk
                    </p>

                    <h2 class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $summary['low'] }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                    🟢
                </div>
            </div>
        </div>

        <div class="bg-white border border-amber-100 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Medium Risk
                    </p>

                    <h2 class="text-3xl font-bold text-amber-500 mt-2">
                        {{ $summary['medium'] }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center">
                    🟠
                </div>
            </div>
        </div>

        <div class="bg-white border border-red-100 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        High Risk
                    </p>

                    <h2 class="text-3xl font-bold text-red-600 mt-2">
                        {{ $summary['high'] }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center">
                    🔴
                </div>
            </div>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">

        <div class="flex flex-col lg:flex-row gap-4">

            <div class="relative flex-1">

                <input
                    type="text"
                    id="countrySearch"
                    placeholder="Search country..."
                    class="w-full border border-slate-200 rounded-xl px-5 py-3.5 pl-12 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                >

                <span class="absolute left-4 top-1/2 -translate-y-1/2">
                    🔍
                </span>

            </div>

            <select
                id="riskFilter"
                class="border border-slate-200 rounded-xl px-5 py-3.5 lg:w-64 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            >
                <option value="ALL">
                    All Risk Levels
                </option>

                <option value="LOW">
                    Low Risk
                </option>

                <option value="MEDIUM">
                    Medium Risk
                </option>

                <option value="HIGH">
                    High Risk
                </option>
            </select>

            <button
                type="button"
                id="resetMap"
                class="px-5 py-3.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition"
            >
                Reset Map
            </button>

        </div>

    </div>


    {{-- MAP --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">

        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-xl font-bold text-slate-900">
                    Supply Chain Risk Distribution
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Country locations are calculated from available port coordinates.
                </p>
            </div>

            <div class="flex flex-wrap gap-4 text-sm">

                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    Low
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    Medium
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    High
                </div>

            </div>

        </div>

        <div id="riskMap"></div>

    </div>


    {{-- INFORMATION --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6">
            <div class="text-2xl mb-4">
                🌍
            </div>

            <h3 class="font-bold text-slate-900">
                Geographic Monitoring
            </h3>

            <p class="text-sm text-slate-600 mt-2 leading-6">
                Risk locations are mapped using the geographical distribution
                of supply chain ports.
            </p>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="text-2xl mb-4">
                ⚠️
            </div>

            <h3 class="font-bold text-slate-900">
                Risk Intelligence
            </h3>

            <p class="text-sm text-slate-600 mt-2 leading-6">
                Each country is evaluated using five supply chain risk
                indicators and weighted risk scoring.
            </p>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="text-2xl mb-4">
                🚢
            </div>

            <h3 class="font-bold text-slate-900">
                Port-Based Location
            </h3>

            <p class="text-sm text-slate-600 mt-2 leading-6">
                Country map positions are dynamically calculated from
                available port coordinates.
            </p>
        </div>

    </div>

</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const riskData = @json($riskMapData);

    const map = L.map('riskMap', {
        zoomControl: true,
        minZoom: 2,
        worldCopyJump: true
    }).setView([15, 15], 2);

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }
    ).addTo(map);


    const markerLayer = L.layerGroup().addTo(map);

    const markerReferences = [];


    function riskClass(level) {

        if (level === 'HIGH') {
            return 'risk-high';
        }

        if (level === 'MEDIUM') {
            return 'risk-medium';
        }

        return 'risk-low';
    }


    function riskTextColor(level) {

        if (level === 'HIGH') {
            return '#dc2626';
        }

        if (level === 'MEDIUM') {
            return '#d97706';
        }

        return '#16a34a';
    }


    function createPopup(country) {

        const flag = country.flag
            ? `
                <img
                    src="${country.flag}"
                    alt="${country.country}"
                    style="
                        width:44px;
                        height:32px;
                        object-fit:cover;
                        border-radius:8px;
                    "
                >
            `
            : '🌍';

        return `
            <div style="font-family: Inter, sans-serif;">

                <div style="
                    padding:20px;
                    border-bottom:1px solid #f1f5f9;
                ">

                    <div style="
                        display:flex;
                        align-items:center;
                        gap:12px;
                    ">

                        ${flag}

                        <div>
                            <div style="
                                font-size:17px;
                                font-weight:800;
                                color:#0f172a;
                            ">
                                ${country.country}
                            </div>

                            <div style="
                                font-size:12px;
                                color:#94a3b8;
                                margin-top:3px;
                            ">
                                ${country.code} · ${country.region ?? '-'}
                            </div>
                        </div>

                    </div>

                </div>


                <div style="padding:20px;">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        margin-bottom:18px;
                    ">

                        <div>
                            <div style="
                                font-size:12px;
                                color:#64748b;
                            ">
                                Risk Score
                            </div>

                            <div style="
                                font-size:30px;
                                font-weight:800;
                                color:#0f172a;
                                margin-top:4px;
                            ">
                                ${country.total_score}
                            </div>
                        </div>

                        <div style="
                            padding:8px 14px;
                            border-radius:999px;
                            background:#f8fafc;
                            color:${riskTextColor(country.risk_level)};
                            font-size:12px;
                            font-weight:800;
                        ">
                            ${country.risk_level} RISK
                        </div>

                    </div>


                    <div style="
                        background:#f8fafc;
                        border-radius:14px;
                        padding:14px;
                        margin-bottom:14px;
                    ">

                        <div style="
                            font-size:11px;
                            color:#94a3b8;
                            text-transform:uppercase;
                            font-weight:700;
                        ">
                            Main Risk Indicator
                        </div>

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            margin-top:7px;
                        ">

                            <span style="
                                font-weight:700;
                                color:#334155;
                            ">
                                ${country.main_indicator}
                            </span>

                            <span style="
                                font-weight:800;
                                color:#0f172a;
                            ">
                                ${country.main_indicator_score}
                            </span>

                        </div>

                    </div>


                    <div style="
                        display:grid;
                        grid-template-columns:1fr 1fr;
                        gap:10px;
                        margin-bottom:16px;
                    ">

                        <div style="
                            border:1px solid #f1f5f9;
                            border-radius:12px;
                            padding:12px;
                        ">
                            <div style="
                                font-size:11px;
                                color:#94a3b8;
                            ">
                                Ports
                            </div>

                            <div style="
                                font-size:16px;
                                font-weight:800;
                                color:#0f172a;
                                margin-top:4px;
                            ">
                                ${country.port_count}
                            </div>
                        </div>

                        <div style="
                            border:1px solid #f1f5f9;
                            border-radius:12px;
                            padding:12px;
                        ">
                            <div style="
                                font-size:11px;
                                color:#94a3b8;
                            ">
                                Capital
                            </div>

                            <div style="
                                font-size:14px;
                                font-weight:700;
                                color:#0f172a;
                                margin-top:4px;
                            ">
                                ${country.capital ?? '-'}
                            </div>
                        </div>

                    </div>


                    <a
                        href="${country.detail_url}"
                        style="
                            display:block;
                            text-align:center;
                            text-decoration:none;
                            background:#059669;
                            color:white;
                            padding:12px;
                            border-radius:12px;
                            font-weight:700;
                        "
                    >
                        View Risk History →
                    </a>

                </div>

            </div>
        `;
    }


    function renderMarkers() {

        markerLayer.clearLayers();

        markerReferences.length = 0;

        const search = document
            .getElementById('countrySearch')
            .value
            .toLowerCase()
            .trim();

        const level = document
            .getElementById('riskFilter')
            .value;


        const filteredData = riskData.filter(function (country) {

            const matchesSearch = country.country
                .toLowerCase()
                .includes(search);

            const matchesLevel =
                level === 'ALL'
                || country.risk_level === level;

            return matchesSearch && matchesLevel;
        });


        filteredData.forEach(function (country) {

            const markerIcon = L.divIcon({
                className: '',
                html: `
                    <div class="risk-marker ${riskClass(country.risk_level)}">
                        ${country.total_score}
                    </div>
                `,
                iconSize: [38, 38],
                iconAnchor: [19, 19],
                popupAnchor: [0, -20]
            });


            const marker = L.marker(
                [
                    country.latitude,
                    country.longitude
                ],
                {
                    icon: markerIcon
                }
            );

            marker.bindPopup(
                createPopup(country),
                {
                    maxWidth: 340
                }
            );

            marker.addTo(markerLayer);


            markerReferences.push({
                country: country,
                marker: marker
            });

        });


        if (
            search !== ''
            && filteredData.length === 1
        ) {

            const country = filteredData[0];

            map.flyTo(
                [
                    country.latitude,
                    country.longitude
                ],
                5,
                {
                    duration: 1.2
                }
            );


            const reference = markerReferences.find(function (item) {
                return item.country.id === country.id;
            });

            if (reference) {

                setTimeout(function () {
                    reference.marker.openPopup();
                }, 900);

            }

        }

    }


    document
        .getElementById('countrySearch')
        .addEventListener(
            'input',
            renderMarkers
        );


    document
        .getElementById('riskFilter')
        .addEventListener(
            'change',
            renderMarkers
        );


    document
        .getElementById('resetMap')
        .addEventListener(
            'click',
            function () {

                document
                    .getElementById('countrySearch')
                    .value = '';

                document
                    .getElementById('riskFilter')
                    .value = 'ALL';

                map.closePopup();

                map.flyTo(
                    [15, 15],
                    2,
                    {
                        duration: 1
                    }
                );

                renderMarkers();

            }
        );


    renderMarkers();

});
</script>

@endsection