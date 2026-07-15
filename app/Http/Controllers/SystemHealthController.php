<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\MonitoringLog;
use App\Models\RiskAlert;
use App\Models\RiskScore;
use Illuminate\Support\Facades\DB;
use Throwable;

class SystemHealthController extends Controller
{
    public function index()
    {
        $databaseStatus = $this->checkDatabase();

        $latestMonitoring = MonitoringLog::query()
            ->latest('completed_at')
            ->first();

        $monitoringStatus = $this->getMonitoringStatus(
            $latestMonitoring
        );

        $riskScoringStatus = RiskScore::query()->exists()
            ? 'OPERATIONAL'
            : 'NO DATA';

        $riskAlertStatus = RiskAlert::query()->exists()
            ? 'OPERATIONAL'
            : 'STANDBY';

        $schedulerStatus = $this->getSchedulerStatus(
            $latestMonitoring
        );

        $totalCountries = Country::query()->count();

        $totalRiskScores = RiskScore::query()->count();

        $totalAlerts = RiskAlert::query()->count();

        $unreadAlerts = RiskAlert::query()
            ->where('is_read', false)
            ->count();

        $successfulRuns = MonitoringLog::query()
            ->where('status', 'SUCCESS')
            ->count();

        $failedRuns = MonitoringLog::query()
            ->whereIn('status', [
                'FAILED',
                'PARTIAL',
            ])
            ->count();

        $systemServices = [
            [
                'name' => 'Database Connection',
                'description' => 'Primary GSCRM database connectivity.',
                'status' => $databaseStatus,
            ],
            [
                'name' => 'Monitoring Engine',
                'description' => 'Automated global supply chain monitoring engine.',
                'status' => $monitoringStatus,
            ],
            [
                'name' => 'Risk Scoring Engine',
                'description' => 'Country supply chain risk calculation service.',
                'status' => $riskScoringStatus,
            ],
            [
                'name' => 'Risk Alert Engine',
                'description' => 'Critical risk indicator alert generator.',
                'status' => $riskAlertStatus,
            ],
            [
                'name' => 'Task Scheduler',
                'description' => 'Automated hourly risk monitoring scheduler.',
                'status' => $schedulerStatus,
            ],
        ];

        $operationalServices = collect($systemServices)
            ->where('status', 'OPERATIONAL')
            ->count();

        $totalServices = count($systemServices);

        $healthPercentage = $totalServices > 0
            ? round(
                ($operationalServices / $totalServices) * 100
            )
            : 0;

        $overallStatus = match (true) {
            $healthPercentage === 100 => 'HEALTHY',
            $healthPercentage >= 60 => 'DEGRADED',
            default => 'CRITICAL',
        };

        return view('system.health', compact(
            'databaseStatus',
            'latestMonitoring',
            'monitoringStatus',
            'riskScoringStatus',
            'riskAlertStatus',
            'schedulerStatus',
            'totalCountries',
            'totalRiskScores',
            'totalAlerts',
            'unreadAlerts',
            'successfulRuns',
            'failedRuns',
            'systemServices',
            'operationalServices',
            'totalServices',
            'healthPercentage',
            'overallStatus'
        ));
    }

    private function checkDatabase(): string
    {
        try {
            DB::connection()->getPdo();

            return 'OPERATIONAL';
        } catch (Throwable $exception) {
            return 'OFFLINE';
        }
    }

    private function getMonitoringStatus(
        ?MonitoringLog $latestMonitoring
    ): string {
        if (!$latestMonitoring) {
            return 'NO DATA';
        }

        if ($latestMonitoring->status === 'SUCCESS') {
            return 'OPERATIONAL';
        }

        if ($latestMonitoring->status === 'PARTIAL') {
            return 'DEGRADED';
        }

        return 'FAILED';
    }

    private function getSchedulerStatus(
        ?MonitoringLog $latestMonitoring
    ): string {
        if (!$latestMonitoring) {
            return 'NO DATA';
        }

        $lastExecution = $latestMonitoring->completed_at
            ?? $latestMonitoring->created_at;

        if (!$lastExecution) {
            return 'NO DATA';
        }

        return $lastExecution->greaterThanOrEqualTo(
            now()->subHours(2)
        )
            ? 'OPERATIONAL'
            : 'DEGRADED';
    }
}