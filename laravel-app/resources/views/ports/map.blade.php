@extends('layouts.main')

@section('content')

@include('partials.nav.infrastructure')

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<style>
    #portMapFull {
        height: 620px;
        width: 100%;
        z-index: 1;
        border-radius: 0 0 24px 24px;
    }

    .port-marker {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: #2563eb;
        color: white;
        font-size: 16px;
        border: 3px solid rgba(255, 255, 255, 0.95);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.20);
        transition: 0.2s ease;
    }

    .port-marker:hover {
        transform: scale(1.12);
    }

    .leaflet-popup-content-wrapper {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18);
    }

    .leaflet-popup-content {
        margin: 0;
        width: 280px !important;
    }

    .leaflet-popup-tip {
        box-shadow: none;
    }
</style>

<div class="space-y-8">

    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold mb-4">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                GLOBAL PORT INFRASTRUCTURE
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-slate-900">
                Global Port Map
            </h1>

            <p class="text-slate-500 mt-3 max-w-2xl">
                Interactive map of global port infrastructure for supply chain monitoring.
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 shadow-sm">
            <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">
                Total Ports
            </p>
            <p class="text-2xl font-bold text-slate-900 mt-1">
                {{ $ports->count() }}
            </p>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">
                    Port Distribution
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Each marker represents a port in the global supply chain network.
                </p>
            </div>
        </div>
        <div id="portMapFull"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
            <div class="text-2xl mb-4">🚢</div>
            <h3 class="font-bold text-slate-900">Port Infrastructure</h3>
            <p class="text-sm text-slate-600 mt-2 leading-6">
                Global port locations mapped for supply chain visibility.
            </p>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="text-2xl mb-4">📍</div>
            <h3 class="font-bold text-slate-900">Precise Locations</h3>
            <p class="text-sm text-slate-600 mt-2 leading-6">
                Port coordinates enable accurate geographic monitoring.
            </p>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="text-2xl mb-4">🌊</div>
            <h3 class="font-bold text-slate-900">Maritime Routes</h3>
            <p class="text-sm text-slate-600 mt-2 leading-6">
                Strategic port locations along global shipping lanes.
            </p>
        </div>
    </div>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ports = @json($ports);

    const map = L.map('portMapFull', {
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

    ports.forEach(function (port) {
        const lat = parseFloat(port.latitude);
        const lng = parseFloat(port.longitude);

        if (isNaN(lat) || isNaN(lng)) return;

        const markerIcon = L.divIcon({
            className: '',
            html: '<div class="port-marker">⚓</div>',
            iconSize: [36, 36],
            iconAnchor: [18, 18],
            popupAnchor: [0, -20]
        });

        const country = port.country?.name ?? '-';

        const content = `
            <div style="font-family: system-ui, sans-serif;">
                <div style="padding:16px;border-bottom:1px solid #f1f5f9;">
                    <div style="font-size:16px;font-weight:800;color:#0f172a;">
                        ⚓ ${port.name}
                    </div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:2px;">
                        ${country} · ${port.harbor_type ?? '-'}
                    </div>
                </div>
                <div style="padding:16px;">
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:4px 0;">
                        <span style="color:#64748b;">Size</span>
                        <span style="font-weight:700;color:#0f172a;">${port.harbor_size ?? '-'}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:4px 0;">
                        <span style="color:#64748b;">Status</span>
                        <span style="font-weight:700;color:#0f172a;">${port.status ?? '-'}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:4px 0;">
                        <span style="color:#64748b;">Coordinates</span>
                        <span style="font-weight:700;color:#0f172a;">${lat.toFixed(4)}, ${lng.toFixed(4)}</span>
                    </div>
                </div>
            </div>
        `;

        const marker = L.marker([lat, lng], { icon: markerIcon });
        marker.bindPopup(content, { maxWidth: 300 });
        marker.addTo(markerLayer);
    });
});
</script>

@endsection
