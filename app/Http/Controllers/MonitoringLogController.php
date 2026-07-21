<?php

namespace App\Http\Controllers;

use App\Models\MonitoringLog;
use Illuminate\Http\Request;

class MonitoringLogController extends Controller
{
    public function index(Request $request)
    {
        $query = MonitoringLog::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $monitoringLogs = $query
            ->latest('started_at')
            ->paginate(15)
            ->withQueryString();

        $totalRuns = MonitoringLog::count();

        $successfulRuns = MonitoringLog::where(
            'status',
            'SUCCESS'
        )->count();

        $failedRuns = MonitoringLog::whereIn(
            'status',
            ['FAILED', 'PARTIAL']
        )->count();

        $averageDuration = (int) round(
            MonitoringLog::avg('duration_ms') ?? 0
        );

        $latestMonitoring = MonitoringLog::latest(
            'started_at'
        )->first();

        return view('monitoring.index', compact(
            'monitoringLogs',
            'totalRuns',
            'successfulRuns',
            'failedRuns',
            'averageDuration',
            'latestMonitoring'
        ));
    }
}