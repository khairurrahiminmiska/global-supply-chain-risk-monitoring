<?php

namespace App\Services;

use App\Models\RiskAlert;
use App\Models\RiskScore;

class RiskAlertService
{
    public function generate(RiskScore $riskScore): array
    {
        $riskScore->loadMissing('country');

        $indicators = [
            [
                'type' => 'WEATHER_RISK',
                'indicator' => 'Weather',
                'score' => (int) $riskScore->weather_score,
            ],
            [
                'type' => 'INFLATION_RISK',
                'indicator' => 'Inflation',
                'score' => (int) $riskScore->inflation_score,
            ],
            [
                'type' => 'CURRENCY_RISK',
                'indicator' => 'Currency',
                'score' => (int) $riskScore->currency_score,
            ],
            [
                'type' => 'NEWS_RISK',
                'indicator' => 'News Sentiment',
                'score' => (int) $riskScore->news_score,
            ],
            [
                'type' => 'PORT_RISK',
                'indicator' => 'Port Infrastructure',
                'score' => (int) $riskScore->port_score,
            ],
        ];

        $alerts = [];

        foreach ($indicators as $indicator) {

            $level = $this->determineLevel($indicator['score']);

            if ($level === 'LOW') {
                continue;
            }

            $latestAlert = RiskAlert::where(
                'country_id',
                $riskScore->country_id
            )
                ->where('type', $indicator['type'])
                ->latest('triggered_at')
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Anti Duplicate Alert
            |--------------------------------------------------------------------------
            |
            | Jangan buat alert baru jika level dan score masih sama.
            |
            */

            if (
                $latestAlert &&
                $latestAlert->level === $level &&
                (int) $latestAlert->risk_score === $indicator['score']
            ) {
                continue;
            }

            $alert = RiskAlert::create([
                'country_id' => $riskScore->country_id,
                'risk_score_id' => $riskScore->id,
                'type' => $indicator['type'],
                'level' => $level,
                'title' => $this->generateTitle(
                    $indicator['indicator'],
                    $level
                ),
                'message' => $this->generateMessage(
                    $riskScore,
                    $indicator['indicator'],
                    $level,
                    $indicator['score']
                ),
                'risk_score' => $indicator['score'],
                'is_read' => false,
                'triggered_at' => now(),
            ]);

            $alerts[] = $alert;
        }

        return $alerts;
    }

    private function determineLevel(int $score): string
    {
        return match (true) {
            $score >= 70 => 'HIGH',
            $score >= 40 => 'MEDIUM',
            default => 'LOW',
        };
    }

    private function generateTitle(
        string $indicator,
        string $level
    ): string {
        return "{$level} {$indicator} Risk";
    }

    private function generateMessage(
        RiskScore $riskScore,
        string $indicator,
        string $level,
        int $score
    ): string {
        $country = $riskScore->country?->name ?? 'Unknown Country';

        return "{$country} has a {$level} {$indicator} risk indicator with a score of {$score}.";
    }
}