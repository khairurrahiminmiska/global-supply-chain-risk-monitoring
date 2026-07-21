@extends('layouts.main')

@section('content')

@include('partials.nav.risk')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Risk Alert Center
            </h1>

            <p class="text-gray-500 mt-2">
                Monitor critical supply chain risk alerts.
            </p>
        </div>

        @if($unreadAlerts > 0)

            <form
                method="POST"
                action="{{ route('risk-alerts.read-all') }}"
            >
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold transition"
                >
                    ✓ Mark All as Read
                </button>

            </form>

        @endif

    </div>


    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-gray-500 text-sm">Total Alerts</p>

            <h2 class="text-3xl font-bold text-slate-800 mt-2">
                {{ $totalAlerts }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-gray-500 text-sm">Unread Alerts</p>

            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $unreadAlerts }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-gray-500 text-sm">High Alerts</p>

            <h2 class="text-3xl font-bold text-red-600 mt-2">
                {{ $highAlerts }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-gray-500 text-sm">Warning Alerts</p>

            <h2 class="text-3xl font-bold text-orange-500 mt-2">
                {{ $warningAlerts }}
            </h2>
        </div>

    </div>


    {{-- FILTER --}}
    <form
        method="GET"
        action="{{ route('risk-alerts.index') }}"
        class="bg-white border rounded-2xl p-5 flex flex-col md:flex-row gap-4"
    >

        <select
            name="level"
            class="border rounded-xl px-4 py-3"
        >
            <option value="">All Levels</option>

            <option value="HIGH" @selected(request('level') === 'HIGH')>
                High
            </option>

            <option value="WARNING" @selected(request('level') === 'WARNING')>
                Warning
            </option>
        </select>

        <select
            name="status"
            class="border rounded-xl px-4 py-3"
        >
            <option value="">All Status</option>

            <option value="unread" @selected(request('status') === 'unread')>
                Unread
            </option>

            <option value="read" @selected(request('status') === 'read')>
                Read
            </option>
        </select>

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold"
        >
            Filter
        </button>

        <a
            href="{{ route('risk-alerts.index') }}"
            class="bg-slate-100 hover:bg-slate-200 px-6 py-3 rounded-xl font-semibold text-center"
        >
            Reset
        </a>

    </form>


    {{-- ALERT LIST --}}
    <div class="space-y-4">

        @forelse($alerts as $alert)

            <div class="bg-white border rounded-2xl shadow-sm p-6
                {{ !$alert->is_read ? 'border-l-4 border-l-blue-600' : '' }}">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                    <div>

                        <div class="flex items-center gap-3 mb-3">

                            @if($alert->level === 'HIGH')

                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-bold">
                                    HIGH
                                </span>

                            @else

                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-bold">
                                    WARNING
                                </span>

                            @endif

                            @if(!$alert->is_read)

                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                    NEW
                                </span>

                            @endif

                        </div>

                        <h2 class="text-xl font-bold text-slate-800">
                            {{ $alert->title }}
                        </h2>

                        <p class="text-gray-600 mt-2">
                            {{ $alert->message }}
                        </p>

                        <div class="flex flex-wrap gap-5 mt-4 text-sm text-gray-500">

                            <span>
                                {{ $alert->country?->name ?? 'Unknown' }}
                            </span>

                            <span>
                                Score: {{ $alert->risk_score }}
                            </span>

                            <span>
                                {{ $alert->triggered_at?->format('d M Y H:i:s') }}
                            </span>

                        </div>

                    </div>


                    @if(!$alert->is_read)

                        <form
                            method="POST"
                            action="{{ route('risk-alerts.read', $alert) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="bg-slate-800 hover:bg-slate-700 text-white px-5 py-3 rounded-xl font-semibold"
                            >
                                ✓ Mark as Read
                            </button>

                        </form>

                    @else

                        <span class="text-green-600 font-semibold">
                            ✓ Read
                        </span>

                    @endif

                </div>

            </div>

        @empty

            <div class="bg-white rounded-2xl border p-12 text-center">

                <div class="text-4xl font-bold text-slate-300 mb-4">!</div>

                <p class="text-gray-500">
                    No risk alerts found.
                </p>

            </div>

        @endforelse

    </div>


    @if($alerts->hasPages())

        <div>
            {{ $alerts->links() }}
        </div>

    @endif

</div>

@endsection