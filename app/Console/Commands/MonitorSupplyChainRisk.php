<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\MonitoringLog;
use App\Services\RiskScoringService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Throwable;

#[Signature('risk:monitor')]
#[Description('Monitor and calculate global supply chain risk for all countries')]
class MonitorSupplyChainRisk extends Command
{
    public function handle(
        RiskScoringService $riskScoringService
    ): int {
        $startedAt = now();

        $startTime = microtime(true);

        $this->info('==============================================');
        $this->info(' GLOBAL SUPPLY CHAIN RISK MONITORING');
        $this->info('==============================================');

        $this->newLine();

        $countries = Country::query()
            ->withCount('ports')
            ->orderBy('name')
            ->get();

        if ($countries->isEmpty()) {
            MonitoringLog::create([
                'type' => 'RISK_MONITORING',
                'status' => 'WARNING',
                'total_countries' => 0,
                'success_count' => 0,
                'failed_count' => 0,
                'started_at' => $startedAt,
                'completed_at' => now(),
                'duration_ms' => 0,
                'message' => 'No country data found.',
            ]);

            $this->warn('No country data found.');

            return self::SUCCESS;
        }

        $this->info(
            "Monitoring {$countries->count()} countries..."
        );

        $this->newLine();

        $progressBar = $this->output->createProgressBar(
            $countries->count()
        );

        $progressBar->start();

        $successCount = 0;

        $failedCount = 0;

        $failedCountries = [];

        foreach ($countries as $country) {
            try {
                $riskScoringService->calculate($country);

                $successCount++;
            } catch (Throwable $exception) {
                $failedCount++;

                $failedCountries[] = [
                    'country' => $country->name,
                    'error' => $exception->getMessage(),
                ];
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        $completedAt = now();

        $durationMs = (int) round(
            (microtime(true) - $startTime) * 1000
        );

        $status = $failedCount === 0
            ? 'SUCCESS'
            : ($successCount > 0 ? 'PARTIAL' : 'FAILED');

        MonitoringLog::create([
            'type' => 'RISK_MONITORING',
            'status' => $status,
            'total_countries' => $countries->count(),
            'success_count' => $successCount,
            'failed_count' => $failedCount,
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
            'duration_ms' => $durationMs,
            'message' => $failedCount === 0
                ? 'Global supply chain risk monitoring completed successfully.'
                : "{$failedCount} countries failed during risk monitoring.",
        ]);

        $this->newLine(2);

        $this->info('Risk monitoring completed.');

        $this->newLine();

        $this->table(
            [
                'Metric',
                'Result',
            ],
            [
                [
                    'Total Countries',
                    $countries->count(),
                ],
                [
                    'Successfully Calculated',
                    $successCount,
                ],
                [
                    'Failed',
                    $failedCount,
                ],
                [
                    'Status',
                    $status,
                ],
                [
                    'Duration',
                    $durationMs . ' ms',
                ],
                [
                    'Completed At',
                    $completedAt->format('Y-m-d H:i:s'),
                ],
            ]
        );

        if (!empty($failedCountries)) {
            $this->newLine();

            $this->error('Failed Countries');

            $this->table(
                [
                    'Country',
                    'Error',
                ],
                $failedCountries
            );
        }

        $this->newLine();

        $this->info(
            'Risk History, Risk Alerts and Monitoring Logs have been updated.'
        );

        return $failedCount > 0
            ? self::FAILURE
            : self::SUCCESS;
    }
}
