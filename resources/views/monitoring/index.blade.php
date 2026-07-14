@extends('layouts.main')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>
            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-widest">
                System Operations
            </p>

            <h1 class="text-3xl font-bold text-slate-900 mt-2">
                Monitoring Activity
            </h1>

            <p class="text-slate-500 mt-2">
                Automated global supply chain risk monitoring execution history.
            </p>
        </div>

        @if($latestMonitoring)

            <div class="bg-white border border-emerald-100 rounded-2xl px-5 py-4 shadow-sm">

                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">
                    Last Monitoring
                </p>

                <p class="font-bold text-slate-800 mt-1">
                    {{ $latestMonitoring->completed_at?->format('d M Y H:i:s') ?? '-' }}
                </p>

            </div>

        @endif

    </div>


    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Total Monitoring Runs
            </p>

            <p class="text-4xl font-bold text-slate-900 mt-4">
                {{ $totalRuns }}
            </p>

        </div>


        <div class="bg-white border border-emerald-100 rounded-3xl p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Successful Runs
            </p>

            <p class="text-4xl font-bold text-emerald-600 mt-4">
                {{ $successfulRuns }}
            </p>

        </div>


        <div class="bg-white border border-red-100 rounded-3xl p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Failed / Partial
            </p>

            <p class="text-4xl font-bold text-red-500 mt-4">
                {{ $failedRuns }}
            </p>

        </div>


        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Average Duration
            </p>

            <p class="text-4xl font-bold text-slate-900 mt-4">
                {{ number_format($averageDuration) }}
                <span class="text-lg text-slate-400">
                    ms
                </span>
            </p>

        </div>

    </div>


    {{-- FILTER --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">

        <form
            method="GET"
            action="{{ route('monitoring.index') }}"
            class="flex flex-col md:flex-row gap-4"
        >

            <select
                name="status"
                class="border border-slate-200 rounded-xl px-4 py-3 md:w-72 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
            >

                <option value="">
                    All Monitoring Status
                </option>

                <option value="SUCCESS" @selected(request('status') === 'SUCCESS')>
                    Success
                </option>

                <option value="PARTIAL" @selected(request('status') === 'PARTIAL')>
                    Partial
                </option>

                <option value="FAILED" @selected(request('status') === 'FAILED')>
                    Failed
                </option>

                <option value="WARNING" @selected(request('status') === 'WARNING')>
                    Warning
                </option>

            </select>

            <button
                type="submit"
                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition"
            >
                Filter Activity
            </button>

            <a
                href="{{ route('monitoring.index') }}"
                class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-center transition"
            >
                Reset
            </a>

        </form>

    </div>


    {{-- ACTIVITY TABLE --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100">

            <h2 class="text-xl font-bold text-slate-900">
                System Execution History
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Recorded execution results from the automated risk monitoring engine.
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr class="text-xs uppercase tracking-wider text-slate-500">

                        <th class="px-6 py-4 text-left">
                            Started
                        </th>

                        <th class="px-6 py-4 text-left">
                            Type
                        </th>

                        <th class="px-6 py-4 text-center">
                            Countries
                        </th>

                        <th class="px-6 py-4 text-center">
                            Success
                        </th>

                        <th class="px-6 py-4 text-center">
                            Failed
                        </th>

                        <th class="px-6 py-4 text-center">
                            Duration
                        </th>

                        <th class="px-6 py-4 text-center">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($monitoringLogs as $log)

                        <tr class="border-t border-slate-100 hover:bg-emerald-50/40 transition">

                            <td class="px-6 py-5">

                                <p class="font-semibold text-slate-800">
                                    {{ $log->started_at?->format('d M Y') ?? '-' }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $log->started_at?->format('H:i:s') ?? '-' }}
                                </p>

                            </td>


                            <td class="px-6 py-5">

                                <span class="font-semibold text-slate-700">
                                    {{ str_replace('_', ' ', $log->type) }}
                                </span>

                            </td>


                            <td class="px-6 py-5 text-center font-semibold">
                                {{ $log->total_countries }}
                            </td>


                            <td class="px-6 py-5 text-center">

                                <span class="text-emerald-600 font-bold">
                                    {{ $log->success_count }}
                                </span>

                            </td>


                            <td class="px-6 py-5 text-center">

                                <span class="text-red-500 font-bold">
                                    {{ $log->failed_count }}
                                </span>

                            </td>


                            <td class="px-6 py-5 text-center text-slate-600">
                                {{ number_format($log->duration_ms) }} ms
                            </td>


                            <td class="px-6 py-5 text-center">

                                @if($log->status === 'SUCCESS')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                        SUCCESS
                                    </span>

                                @elseif($log->status === 'PARTIAL')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                                        PARTIAL
                                    </span>

                                @elseif($log->status === 'WARNING')

                                    <span class="inline-flex px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                        WARNING
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                        FAILED
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-16 text-center"
                            >

                                <div class="text-4xl mb-4">
                                    🛰️
                                </div>

                                <p class="font-semibold text-slate-700">
                                    No monitoring activity found.
                                </p>

                                <p class="text-sm text-slate-400 mt-1">
                                    Run the risk monitoring command to generate activity logs.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($monitoringLogs->hasPages())

            <div class="p-6 border-t border-slate-100">

                {{ $monitoringLogs->links() }}

            </div>

        @endif

    </div>

</div>

@endsection