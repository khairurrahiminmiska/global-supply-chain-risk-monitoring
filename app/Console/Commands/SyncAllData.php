<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\MonitoringLog;
use App\Services\ExchangeRateService;
use App\Services\NewsService;
use App\Services\RiskScoringService;
use App\Services\WeatherService;
use App\Services\WorldBankService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Throwable;

#[Signature('sync:all {--type= : Sync specific type only: economy,weather,exchange,news,risk}')]
#[Description('Sync all data for all countries: economy, weather, exchange rate, news, and risk score')]
class SyncAllData extends Command
{
    public function handle(
        WorldBankService $worldBankService,
        WeatherService $weatherService,
        ExchangeRateService $exchangeRateService,
        NewsService $newsService,
        RiskScoringService $riskScoringService
    ): int {
        set_time_limit(0);

        $startedAt = now();
        $startTime = microtime(true);

        $this->info('==============================================');
        $this->info(' SYNC ALL DATA - GLOBAL SUPPLY CHAIN');
        $this->info('==============================================');
        $this->newLine();

        $countries = Country::query()->orderBy('name')->get();

        if ($countries->isEmpty()) {
            $this->warn('No countries found. Run db:seed first.');

            return self::SUCCESS;
        }

        $this->info("Found {$countries->count()} countries.");
        $this->newLine();

        $type = $this->option('type');

        $steps = [
            'economy' => 'Economy (World Bank)',
            'weather' => 'Weather (Open-Meteo)',
            'exchange' => 'Exchange Rate',
            'news' => 'News (GNews)',
            'risk' => 'Risk Score',
        ];

        if ($type && ! isset($steps[$type])) {
            $this->error("Invalid type: {$type}. Available: ".implode(', ', array_keys($steps)));

            return self::FAILURE;
        }

        $runSteps = $type ? [$type => $steps[$type]] : $steps;

        $results = [];

        foreach ($runSteps as $stepKey => $stepLabel) {
            $this->info(">> Step: {$stepLabel}");
            $this->newLine();

            $stepStart = microtime(true);
            $success = 0;
            $failed = 0;

            $progressBar = $this->output->createProgressBar($countries->count());
            $progressBar->start();

            foreach ($countries as $country) {
                try {
                    match ($stepKey) {
                        'economy' => $worldBankService->sync($country),
                        'weather' => $weatherService->sync($country),
                        'exchange' => $exchangeRateService->sync($country),
                        'news' => $newsService->sync($country),
                        'risk' => $riskScoringService->calculate($country),
                    };
                    $success++;
                } catch (Throwable $e) {
                    $failed++;
                }

                $progressBar->advance();

                if (in_array($stepKey, ['exchange', 'news'])) {
                    usleep(1100000);
                }
            }

            $progressBar->finish();
            $this->newLine();

            $durationMs = (int) round((microtime(true) - $stepStart) * 1000);

            $results[$stepKey] = [
                'label' => $stepLabel,
                'success' => $success,
                'failed' => $failed,
                'duration' => $durationMs,
            ];

            $this->info("   Done: {$success} ok, {$failed} failed ({$durationMs} ms)");
            $this->newLine();
        }

        $completedAt = now();
        $totalDurationMs = (int) round((microtime(true) - $startTime) * 1000);

        $this->info('==============================================');
        $this->info(' SUMMARY');
        $this->info('==============================================');
        $this->newLine();

        $tableData = [];
        foreach ($results as $r) {
            $tableData[] = [
                $r['label'],
                $r['success'],
                $r['failed'],
                $r['duration'].' ms',
            ];
        }

        $this->table(
            ['Step', 'Success', 'Failed', 'Duration'],
            $tableData
        );

        $this->info("Total duration: {$totalDurationMs} ms");
        $this->info("Completed at: {$completedAt->format('Y-m-d H:i:s')}");

        MonitoringLog::create([
            'type' => 'SYNC_ALL',
            'status' => 'SUCCESS',
            'total_countries' => $countries->count(),
            'success_count' => array_sum(array_column($results, 'success')),
            'failed_count' => array_sum(array_column($results, 'failed')),
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
            'duration_ms' => $totalDurationMs,
            'message' => 'Full data sync completed. Steps: '.implode(', ', array_keys($results)),
        ]);

        $this->newLine();
        $this->info('Monitoring log saved. All data synced.');

        return self::SUCCESS;
    }
}
