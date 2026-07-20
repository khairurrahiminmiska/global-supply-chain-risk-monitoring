@extends('layouts.main')

@section('content')

@include('partials.nav.infrastructure')

<div class="space-y-8">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-5 py-4">
            <p class="font-semibold">
                Weather Intelligence Updated
            </p>

            <p class="text-sm mt-1">
                {{ session('success') }}
            </p>
        </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-6">

        <div>
            <div class="flex items-center gap-2 text-emerald-600 text-sm font-semibold mb-3">
                <span>🌦</span>
                <span>Global Weather Intelligence</span>
            </div>

            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Weather Monitor
            </h1>

            <p class="text-slate-500 mt-2 max-w-2xl">
                Monitor weather conditions and identify environmental threats
                that may impact global supply chain operations.
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 shadow-sm">
            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">
                Monitoring Coverage
            </p>

            <div class="flex items-end gap-2 mt-1">
                <span class="text-2xl font-bold text-slate-900">
                    {{ $monitoredCountries }}
                </span>

                <span class="text-slate-400 mb-1">
                    / {{ $totalCountries }} countries
                </span>
            </div>
        </div>

    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Monitored Countries
                    </p>

                    <p class="text-3xl font-bold text-slate-900 mt-3">
                        {{ $monitoredCountries }}
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-xl">
                    🌍
                </div>
            </div>

            <p class="text-xs text-emerald-600 font-semibold mt-5">
                Live weather intelligence
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Critical Conditions
                    </p>

                    <p class="text-3xl font-bold text-slate-900 mt-3">
                        {{ $criticalWeather }}
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-xl">
                    ⛈️
                </div>
            </div>

            <p class="text-xs text-red-500 font-semibold mt-5">
                Extreme weather exposure
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Weather Warnings
                    </p>

                    <p class="text-3xl font-bold text-slate-900 mt-3">
                        {{ $warningWeather }}
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-xl">
                    ⚠️
                </div>
            </div>

            <p class="text-xs text-amber-600 font-semibold mt-5">
                Conditions require attention
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Average Temperature
                    </p>

                    <p class="text-3xl font-bold text-slate-900 mt-3">
                        {{ $averageTemperature }}°C
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-sky-50 flex items-center justify-center text-xl">
                    🌡️
                </div>
            </div>

            <p class="text-xs text-sky-600 font-semibold mt-5">
                Across monitored locations
            </p>
        </div>

    </div>

    {{-- STORM RISK INTELLIGENCE --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-7 shadow-sm">

        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

            <div>
                <div class="flex items-center gap-2 text-emerald-600 text-sm font-semibold">
                    <span>⚡</span>
                    <span>Storm Risk Intelligence</span>
                </div>

                <h2 class="text-2xl font-bold text-slate-900 mt-3">
                    Global Storm Risk Distribution
                </h2>

                <p class="text-slate-500 mt-2 max-w-2xl">
                    Storm exposure is evaluated from Open-Meteo weather codes
                    to identify atmospheric threats to global logistics operations.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                @foreach([
                    'LOW' => [
                        'icon' => '●',
                        'class' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                    ],
                    'MEDIUM' => [
                        'icon' => '●',
                        'class' => 'bg-amber-50 text-amber-700 border-amber-100',
                    ],
                    'HIGH' => [
                        'icon' => '●',
                        'class' => 'bg-orange-50 text-orange-700 border-orange-100',
                    ],
                    'CRITICAL' => [
                        'icon' => '●',
                        'class' => 'bg-red-50 text-red-700 border-red-100',
                    ],
                ] as $risk => $config)

                    <div class="min-w-28 border rounded-2xl p-4 {{ $config['class'] }}">
                        <p class="text-xs font-bold">
                            {{ $config['icon'] }} {{ $risk }}
                        </p>

                        <p class="text-2xl font-bold mt-2">
                            {{ $stormRiskSummary[$risk] ?? 0 }}
                        </p>
                    </div>

                @endforeach

            </div>

        </div>

    </div>

    {{-- GLOBAL STATUS --}}
    <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 rounded-3xl p-7 text-white shadow-lg shadow-emerald-900/10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <p class="text-emerald-100 text-sm font-semibold">
                    GLOBAL WEATHER STATUS
                </p>

                <h2 class="text-2xl font-bold mt-2">
                    @if($criticalWeather > 0)
                        Critical weather threats detected
                    @elseif($warningWeather > 0)
                        Weather conditions require monitoring
                    @else
                        Global weather conditions remain stable
                    @endif
                </h2>

                <p class="text-emerald-100 mt-2 max-w-2xl">
                    Environmental conditions are continuously evaluated
                    to identify potential disruptions to transportation,
                    ports and international supply chain networks.
                </p>
            </div>

            <div class="bg-white/10 border border-white/20 rounded-2xl px-6 py-5 min-w-48">
                <p class="text-xs text-emerald-100 uppercase tracking-wider">
                    Weather Threats
                </p>

                <p class="text-3xl font-bold mt-2">
                    {{ $criticalWeather + $warningWeather }}
                </p>

                <p class="text-sm text-emerald-100 mt-1">
                    active conditions
                </p>
            </div>

        </div>

    </div>

    {{-- ACTION --}}
    <div class="flex flex-col sm:flex-row gap-3">

        <form method="POST" action="{{ route('weather.sync') }}" data-ajax="true">
            @csrf

            <button
                type="submit"
                class="w-full sm:w-auto px-5 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-semibold transition shadow-sm"
            >
                <span class="mr-2">↻</span>
                Sync Global Weather
            </button>
        </form>

        <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 shadow-sm">
            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">
                Monitoring Coverage
            </p>

            <div class="flex items-end gap-2 mt-1">
                <span class="text-2xl font-bold text-slate-900">
                    {{ $monitoredCountries }}
                </span>

                <span class="text-slate-400 mb-1">
                    / {{ $totalCountries }} countries
                </span>
            </div>
        </div>

    </div>

    {{-- FILTER --}}
    <form
        method="GET"
        action="{{ route('weather.index') }}"
        class="flex flex-col lg:flex-row gap-4"
    >
        <div class="flex-1">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search country, capital or country code..."
                class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500"
            >
        </div>

        <div class="lg:w-56">
            <select
                name="condition"
                class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500"
            >
                <option value="">All Conditions</option>

                <option
                    value="WARNING"
                    @selected(request('condition') === 'WARNING')
                >
                    Warning
                </option>

                <option
                    value="CRITICAL"
                    @selected(request('condition') === 'CRITICAL')
                >
                    Critical
                </option>
            </select>
        </div>

        <button
            type="submit"
            class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-2xl transition"
        >
            Analyze
        </button>

        @if(request()->hasAny(['search', 'condition']))
            <a
                href="{{ route('weather.index') }}"
                class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-2xl text-center transition"
            >
                Reset
            </a>
        @endif

    </form>

    {{-- WEATHER MAP --}}
    @if($mapWeather->isNotEmpty())
        <link
            rel="stylesheet"
            href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        />

        <style>
            #weatherMap {
                height: 480px;
                width: 100%;
                z-index: 1;
                border-radius: 0 0 24px 24px;
            }

            .weather-marker {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                color: white;
                font-size: 14px;
                font-weight: 800;
                border: 3px solid rgba(255, 255, 255, 0.95);
                box-shadow: 0 4px 16px rgba(15, 23, 42, 0.18);
                transition: 0.2s ease;
            }

            .weather-marker:hover {
                transform: scale(1.15);
            }

            .marker-rain { background: #3b82f6; }
            .marker-storm { background: #8b5cf6; }
            .marker-wind { background: #f97316; }
            .marker-snow { background: #06b6d4; }
            .marker-fog { background: #eab308; }
            .marker-clear { background: #22c55e; }
            .marker-cloudy { background: #6b7280; }
            .marker-drizzle { background: #0ea5e9; }
            .marker-unknown { background: #9ca3af; }

            .weather-popup-content {
                font-family: system-ui, sans-serif;
            }

            .weather-popup-content .popup-header {
                padding: 16px;
                border-bottom: 1px solid #f1f5f9;
            }

            .weather-popup-content .popup-body {
                padding: 16px;
            }

            .weather-popup-content .metric {
                display: flex;
                justify-content: space-between;
                padding: 6px 0;
                font-size: 13px;
            }

            .weather-popup-content .metric-label {
                color: #64748b;
            }

            .weather-popup-content .metric-value {
                font-weight: 700;
                color: #0f172a;
            }
        </style>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">
                        Weather Conditions Map
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Geographical distribution of weather conditions across monitored countries.
                    </p>
                </div>
                <div class="flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#22c55e]"></span>
                        Clear
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#0ea5e9]"></span>
                        Rain
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#8b5cf6]"></span>
                        Storm
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#f97316]"></span>
                        Wind
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#6b7280]"></span>
                        Cloudy
                    </div>
                </div>
            </div>
            <div id="weatherMap"></div>
        </div>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mapWeather = @json($mapWeather);

            const map = L.map('weatherMap', {
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

            function markerClass(condition) {
                const map = {
                    'Rain': 'marker-rain',
                    'Rain Shower': 'marker-rain',
                    'Thunderstorm': 'marker-storm',
                    'Snow': 'marker-snow',
                    'Snow Shower': 'marker-snow',
                    'Fog': 'marker-fog',
                    'Clear Sky': 'marker-clear',
                    'Cloudy': 'marker-cloudy',
                    'Drizzle': 'marker-drizzle',
                };
                return map[condition] || 'marker-unknown';
            }

            function markerIcon(condition) {
                const icons = {
                    'Rain': '🌧',
                    'Rain Shower': '🌧',
                    'Thunderstorm': '⛈',
                    'Snow': '❄',
                    'Snow Shower': '🌨',
                    'Fog': '🌫',
                    'Clear Sky': '☀',
                    'Cloudy': '☁',
                    'Drizzle': '🌦',
                };
                return icons[condition] || '🌤';
            }

            const markerLayer = L.layerGroup().addTo(map);

            mapWeather.forEach(function (w) {
                let condition = w.condition_label;
                let markerClass_name = markerClass(condition);
                let icon = markerIcon(condition);

                if (markerClass_name === 'marker-unknown' && w.wind_speed >= 40) {
                    markerClass_name = 'marker-wind';
                    icon = '💨';
                } else if (condition === 'Thunderstorm') {
                    markerClass_name = 'marker-storm';
                    icon = '⛈';
                }

                const markerIcon_div = L.divIcon({
                    className: '',
                    html: `<div class="weather-marker ${markerClass_name}">${icon}</div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 16],
                    popupAnchor: [0, -18]
                });

                const popupContent = `
                    <div class="weather-popup-content">
                        <div class="popup-header">
                            <div style="font-size:16px;font-weight:800;color:#0f172a;">
                                ${w.country?.name ?? 'Unknown'}
                            </div>
                            <div style="font-size:12px;color:#94a3b8;margin-top:2px;">
                                ${w.country?.capital ?? '-'} · ${w.country?.code ?? '-'}
                            </div>
                        </div>
                        <div class="popup-body">
                            <div class="metric">
                                <span class="metric-label">Condition</span>
                                <span class="metric-value">${condition}</span>
                            </div>
                            <div class="metric">
                                <span class="metric-label">Temperature</span>
                                <span class="metric-value">${w.temperature?.toFixed(1) ?? '-'}°C</span>
                            </div>
                            <div class="metric">
                                <span class="metric-label">Rain</span>
                                <span class="metric-value">${w.rain?.toFixed(1) ?? '0'} mm</span>
                            </div>
                            <div class="metric">
                                <span class="metric-label">Wind Speed</span>
                                <span class="metric-value">${w.wind_speed?.toFixed(1) ?? '0'} km/h</span>
                            </div>
                            <div class="metric" style="border-top:1px solid #f1f5f9;padding-top:8px;margin-top:4px;">
                                <span class="metric-label">Storm Risk</span>
                                <span class="metric-value" style="color:${
                                    w.storm_risk === 'CRITICAL' ? '#dc2626' :
                                    w.storm_risk === 'HIGH' ? '#ea580c' :
                                    w.storm_risk === 'MEDIUM' ? '#d97706' : '#16a34a'
                                }">${w.storm_risk ?? 'LOW'}</span>
                            </div>
                        </div>
                    </div>
                `;

                const marker = L.marker([w.latitude, w.longitude], {
                    icon: markerIcon_div
                });
                marker.bindPopup(popupContent, { maxWidth: 280 });
                marker.addTo(markerLayer);
            });
        });
        </script>
    @endif

    {{-- WEATHER CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($weatherRecords as $weather)

            @php
                $level = $weather->monitoring_level;

                $levelClass = match($level) {
                    'CRITICAL' => 'bg-red-50 text-red-600 border-red-100',
                    'WARNING' => 'bg-amber-50 text-amber-600 border-amber-100',
                    default => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                };

                $stormRisk = strtoupper($weather->storm_risk ?? 'LOW');

                $stormConfig = match($stormRisk) {
                    'CRITICAL' => [
                        'icon' => '🔴',
                        'class' => 'bg-red-50 text-red-700 border-red-100',
                        'description' => 'Severe storm exposure',
                    ],

                    'HIGH' => [
                        'icon' => '🟠',
                        'class' => 'bg-orange-50 text-orange-700 border-orange-100',
                        'description' => 'High storm exposure',
                    ],

                    'MEDIUM' => [
                        'icon' => '🟡',
                        'class' => 'bg-amber-50 text-amber-700 border-amber-100',
                        'description' => 'Moderate storm exposure',
                    ],

                    default => [
                        'icon' => '🟢',
                        'class' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        'description' => 'Low storm exposure',
                    ],
                };

                $weatherIcon = match($weather->condition_label) {
                    'Clear Sky' => '☀️',
                    'Cloudy' => '☁️',
                    'Fog' => '🌫️',
                    'Drizzle' => '🌦️',
                    'Rain' => '🌧️',
                    'Rain Shower' => '🌧️',
                    'Snow' => '❄️',
                    'Snow Shower' => '🌨️',
                    'Thunderstorm' => '⛈️',
                    default => '🌤️',
                };
            @endphp

            <div class="group bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">

                <div class="flex justify-between items-start gap-4">

                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-3xl">
                            {{ $weatherIcon }}
                        </div>

                        <div>
                            <h3 class="font-bold text-lg text-slate-900">
                                {{ $weather->country?->name ?? 'Unknown Country' }}
                            </h3>

                            <p class="text-sm text-slate-400">
                                {{ $weather->country?->capital ?? '-' }}
                                ·
                                {{ $weather->country?->code ?? '-' }}
                            </p>
                        </div>

                    </div>

                    <span class="px-3 py-1 rounded-full border text-xs font-bold {{ $levelClass }}">
                        {{ $level }}
                    </span>

                </div>

                <div class="mt-7">

                    <div class="flex items-end gap-3">

                        <span class="text-4xl font-bold text-slate-900">
                            {{ number_format($weather->temperature, 1) }}°
                        </span>

                        <span class="text-slate-500 mb-1">
                            {{ $weather->condition_label }}
                        </span>

                    </div>

                </div>

                <div class="grid grid-cols-2 gap-3 mt-7">

                    <div class="bg-slate-50 rounded-2xl p-4">
                        <p class="text-xs text-slate-400 font-semibold">
                            RAIN
                        </p>

                        <p class="text-lg font-bold text-slate-800 mt-1">
                            {{ number_format($weather->rain, 2) }} mm
                        </p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-4">
                        <p class="text-xs text-slate-400 font-semibold">
                            WIND SPEED
                        </p>

                        <p class="text-lg font-bold text-slate-800 mt-1">
                            {{ number_format($weather->wind_speed, 1) }} km/h
                        </p>
                    </div>

                </div>

                {{-- STORM RISK --}}
                <div class="mt-3 border rounded-2xl p-4 {{ $stormConfig['class'] }}">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-xs font-bold tracking-wider">
                                STORM RISK
                            </p>

                            <p class="text-sm mt-1 opacity-80">
                                {{ $stormConfig['description'] }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <span>
                                {{ $stormConfig['icon'] }}
                            </span>

                            <span class="font-bold">
                                {{ $stormRisk }}
                            </span>
                        </div>

                    </div>

                </div>

                <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-100">

                    <div>
                        <p class="text-xs text-slate-400">
                            Last weather update
                        </p>

                        <p class="text-sm font-semibold text-slate-600 mt-1">
                            {{ $weather->retrieved_at?->diffForHumans() ?? '-' }}
                        </p>
                    </div>

                    <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition">
                        →
                    </div>

                </div>

            </div>

        @empty

            <div class="md:col-span-2 xl:col-span-3 bg-white border border-slate-200 rounded-3xl p-12 text-center">

                <div class="text-5xl">
                    🌦️
                </div>

                <h3 class="text-xl font-bold text-slate-900 mt-5">
                    Weather intelligence unavailable
                </h3>

                <p class="text-slate-500 mt-2">
                    No weather monitoring records matched the current analysis filter.
                </p>

            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if($weatherRecords->hasPages())
        <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 shadow-sm">
            {{ $weatherRecords->links() }}
        </div>
    @endif

</div>

@endsection