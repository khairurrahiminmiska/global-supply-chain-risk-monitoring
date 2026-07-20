@extends('layouts.main')

@section('content')

@include('partials.nav.system')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-emerald-600">
                System Infrastructure
            </p>

            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                System Health
            </h1>

            <p class="mt-2 text-slate-500">
                Monitor the operational health of the Global Supply Chain Risk Monitoring platform.
            </p>
        </div>

        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-white px-5 py-4 shadow-sm">

            <div class="relative flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50">

                <span class="text-xl">⚡</span>

                @if($overallStatus === 'HEALTHY')
                    <span class="absolute -right-1 -top-1 h-3 w-3 rounded-full bg-emerald-500 ring-4 ring-white"></span>
                @elseif($overallStatus === 'DEGRADED')
                    <span class="absolute -right-1 -top-1 h-3 w-3 rounded-full bg-amber-500 ring-4 ring-white"></span>
                @else
                    <span class="absolute -right-1 -top-1 h-3 w-3 rounded-full bg-red-500 ring-4 ring-white"></span>
                @endif

            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Overall Status
                </p>

                <p class="mt-1 font-bold
                    {{ $overallStatus === 'HEALTHY'
                        ? 'text-emerald-600'
                        : ($overallStatus === 'DEGRADED'
                            ? 'text-amber-600'
                            : 'text-red-600') }}">
                    {{ $overallStatus }}
                </p>
            </div>

        </div>

    </div>


    {{-- SYSTEM HEALTH HERO --}}
    <div class="overflow-hidden rounded-3xl border border-emerald-100 bg-white shadow-sm">

        <div class="grid grid-cols-1 lg:grid-cols-[1.4fr_0.6fr]">

            <div class="p-8 lg:p-10">

                <div class="flex items-start justify-between gap-6">

                    <div>
                        <p class="text-sm font-semibold text-emerald-600">
                            Platform Health Score
                        </p>

                        <h2 class="mt-3 text-5xl font-bold tracking-tight text-slate-900">
                            {{ $healthPercentage }}%
                        </h2>

                        <p class="mt-4 max-w-xl text-slate-500">
                            {{ $operationalServices }} of {{ $totalServices }}
                            system services are currently operating normally.
                        </p>
                    </div>

                    <div class="hidden h-20 w-20 items-center justify-center rounded-3xl bg-emerald-50 text-4xl lg:flex">
                        🛡️
                    </div>

                </div>

                <div class="mt-8">

                    <div class="mb-3 flex items-center justify-between text-sm">

                        <span class="font-medium text-slate-600">
                            Operational health
                        </span>

                        <span class="font-bold text-emerald-600">
                            {{ $healthPercentage }}%
                        </span>

                    </div>

                    <div class="h-3 overflow-hidden rounded-full bg-slate-100">

                        <div
                            class="h-full rounded-full transition-all duration-500
                            {{ $overallStatus === 'HEALTHY'
                                ? 'bg-emerald-500'
                                : ($overallStatus === 'DEGRADED'
                                    ? 'bg-amber-500'
                                    : 'bg-red-500') }}"
                            style="width: {{ $healthPercentage }}%">
                        </div>

                    </div>

                </div>

            </div>

            <div class="border-t border-emerald-100 bg-emerald-50/50 p-8 lg:border-l lg:border-t-0">

                <p class="text-sm font-semibold text-slate-500">
                    Last Monitoring Activity
                </p>

                @if($latestMonitoring)

                    <div class="mt-5">

                        <p class="text-2xl font-bold text-slate-900">
                            {{ $latestMonitoring->status }}
                        </p>

                        <p class="mt-2 text-sm text-slate-500">
                            {{ $latestMonitoring->completed_at?->format('d M Y H:i:s') ?? '-' }}
                        </p>

                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">

                        <div class="rounded-2xl bg-white p-4 shadow-sm">
                            <p class="text-xs text-slate-400">
                                Success
                            </p>

                            <p class="mt-2 text-xl font-bold text-emerald-600">
                                {{ $latestMonitoring->success_count }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-white p-4 shadow-sm">
                            <p class="text-xs text-slate-400">
                                Failed
                            </p>

                            <p class="mt-2 text-xl font-bold text-red-500">
                                {{ $latestMonitoring->failed_count }}
                            </p>
                        </div>

                    </div>

                @else

                    <div class="mt-6 rounded-2xl bg-white p-5 text-sm text-slate-500">
                        Monitoring activity has not been recorded.
                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- METRIC CARDS --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-xl">
                    🌍
                </div>

                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                    Coverage
                </span>

            </div>

            <p class="mt-6 text-sm text-slate-500">
                Countries Monitored
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ $totalCountries }}
            </p>

        </div>


        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-xl">
                    📈
                </div>

                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                    Risk Engine
                </span>

            </div>

            <p class="mt-6 text-sm text-slate-500">
                Risk Scores
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ $totalRiskScores }}
            </p>

        </div>


        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-xl">
                    🔔
                </div>

                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                    Alert Engine
                </span>

            </div>

            <p class="mt-6 text-sm text-slate-500">
                Risk Alerts
            </p>

            <div class="mt-2 flex items-end gap-3">

                <p class="text-3xl font-bold text-slate-900">
                    {{ $totalAlerts }}
                </p>

                @if($unreadAlerts > 0)

                    <span class="mb-1 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600">
                        {{ $unreadAlerts }} unread
                    </span>

                @endif

            </div>

        </div>


        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-xl">
                    ⚙️
                </div>

                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                    Monitoring
                </span>

            </div>

            <p class="mt-6 text-sm text-slate-500">
                Successful Runs
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ $successfulRuns }}
            </p>

        </div>

    </div>


    {{-- SERVICE STATUS --}}
    <div class="rounded-3xl border border-slate-100 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-6 lg:px-8">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-xl font-bold text-slate-900">
                        System Services
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Real-time operational status of core GSCRM services.
                    </p>
                </div>

                <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-600">
                    {{ $operationalServices }}/{{ $totalServices }} Operational
                </span>

            </div>

        </div>

        <div class="divide-y divide-slate-100">

            @foreach($systemServices as $service)

                <div class="flex flex-col gap-5 px-6 py-5 transition hover:bg-slate-50/70 sm:flex-row sm:items-center sm:justify-between lg:px-8">

                    <div class="flex items-center gap-4">

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl
                            {{ $service['status'] === 'OPERATIONAL'
                                ? 'bg-emerald-50'
                                : ($service['status'] === 'DEGRADED'
                                    ? 'bg-amber-50'
                                    : 'bg-red-50') }}">

                            <span class="h-3 w-3 rounded-full
                                {{ $service['status'] === 'OPERATIONAL'
                                    ? 'bg-emerald-500'
                                    : ($service['status'] === 'DEGRADED'
                                        ? 'bg-amber-500'
                                        : 'bg-red-500') }}">
                            </span>

                        </div>

                        <div>
                            <p class="font-semibold text-slate-900">
                                {{ $service['name'] }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $service['description'] }}
                            </p>
                        </div>

                    </div>

                    <span class="w-fit rounded-full px-4 py-2 text-xs font-bold
                        {{ $service['status'] === 'OPERATIONAL'
                            ? 'bg-emerald-50 text-emerald-600'
                            : ($service['status'] === 'DEGRADED'
                                ? 'bg-amber-50 text-amber-600'
                                : 'bg-red-50 text-red-600') }}">

                        {{ $service['status'] }}

                    </span>

                </div>

            @endforeach

        </div>

    </div>


    {{-- MONITORING STATISTICS --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm lg:p-8">

            <h2 class="text-xl font-bold text-slate-900">
                Monitoring Execution
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Summary of automated supply chain monitoring executions.
            </p>

            <div class="mt-8 space-y-5">

                <div class="flex items-center justify-between rounded-2xl bg-emerald-50/70 px-5 py-4">

                    <span class="text-sm font-medium text-slate-600">
                        Successful Runs
                    </span>

                    <span class="text-xl font-bold text-emerald-600">
                        {{ $successfulRuns }}
                    </span>

                </div>

                <div class="flex items-center justify-between rounded-2xl bg-red-50/70 px-5 py-4">

                    <span class="text-sm font-medium text-slate-600">
                        Failed / Partial Runs
                    </span>

                    <span class="text-xl font-bold text-red-600">
                        {{ $failedRuns }}
                    </span>

                </div>

            </div>

        </div>


        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm lg:p-8">

            <h2 class="text-xl font-bold text-slate-900">
                Latest Monitoring Detail
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Latest recorded automated monitoring execution.
            </p>

            @if($latestMonitoring)

                <div class="mt-8 space-y-4">

                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <span class="text-sm text-slate-500">
                            Status
                        </span>

                        <span class="font-bold text-emerald-600">
                            {{ $latestMonitoring->status }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <span class="text-sm text-slate-500">
                            Countries
                        </span>

                        <span class="font-semibold text-slate-900">
                            {{ $latestMonitoring->total_countries }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <span class="text-sm text-slate-500">
                            Duration
                        </span>

                        <span class="font-semibold text-slate-900">
                            {{ number_format($latestMonitoring->duration_ms ?? 0) }} ms
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">
                            Completed
                        </span>

                        <span class="font-semibold text-slate-900">
                            {{ $latestMonitoring->completed_at?->format('d M Y H:i:s') ?? '-' }}
                        </span>
                    </div>

                </div>

            @else

                <div class="mt-8 rounded-2xl bg-slate-50 p-6 text-center text-sm text-slate-500">
                    No monitoring execution data available.
                </div>

            @endif

        </div>

    </div>


    {{-- FOOTER STATUS --}}
    <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm">
                    🌐
                </div>

                <div>
                    <p class="font-bold text-slate-900">
                        Global Supply Chain Risk Monitoring
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        Automated risk monitoring infrastructure status.
                    </p>
                </div>

            </div>

            <div class="flex items-center gap-2">

                <span class="h-2.5 w-2.5 rounded-full
                    {{ $overallStatus === 'HEALTHY'
                        ? 'bg-emerald-500'
                        : ($overallStatus === 'DEGRADED'
                            ? 'bg-amber-500'
                            : 'bg-red-500') }}">
                </span>

                <span class="text-sm font-bold
                    {{ $overallStatus === 'HEALTHY'
                        ? 'text-emerald-600'
                        : ($overallStatus === 'DEGRADED'
                            ? 'text-amber-600'
                            : 'text-red-600') }}">

                    SYSTEM {{ $overallStatus }}

                </span>

            </div>

        </div>

    </div>

</div>

@endsection