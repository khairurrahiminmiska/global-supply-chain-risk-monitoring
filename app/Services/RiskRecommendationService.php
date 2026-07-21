<?php

namespace App\Services;

use App\Models\RiskScore;

class RiskRecommendationService
{
    public function generate(RiskScore $riskScore): array
    {
        $recommendations = [];

        if ($riskScore->weather_score >= 60) {
            $recommendations[] = [
                'indicator' => 'Weather',
                'level' => 'HIGH',
                'recommendation' => 'Monitor extreme weather conditions and prepare alternative transportation routes.',
            ];
        } elseif ($riskScore->weather_score >= 30) {
            $recommendations[] = [
                'indicator' => 'Weather',
                'level' => 'MEDIUM',
                'recommendation' => 'Monitor weather forecasts and possible logistics delays.',
            ];
        }

        if ($riskScore->inflation_score >= 60) {
            $recommendations[] = [
                'indicator' => 'Inflation',
                'level' => 'HIGH',
                'recommendation' => 'Review procurement costs and consider alternative suppliers with more stable pricing.',
            ];
        } elseif ($riskScore->inflation_score >= 30) {
            $recommendations[] = [
                'indicator' => 'Inflation',
                'level' => 'MEDIUM',
                'recommendation' => 'Monitor inflation trends and adjust supply chain budgets.',
            ];
        }

        if ($riskScore->currency_score >= 60) {
            $recommendations[] = [
                'indicator' => 'Currency',
                'level' => 'HIGH',
                'recommendation' => 'Consider currency hedging strategies and diversify transaction currencies.',
            ];
        } elseif ($riskScore->currency_score >= 30) {
            $recommendations[] = [
                'indicator' => 'Currency',
                'level' => 'MEDIUM',
                'recommendation' => 'Monitor exchange rate movements before international transactions.',
            ];
        }

        if ($riskScore->news_score >= 60) {
            $recommendations[] = [
                'indicator' => 'News Sentiment',
                'level' => 'HIGH',
                'recommendation' => 'Review negative news developments and prepare supply chain contingency plans.',
            ];
        } elseif ($riskScore->news_score >= 30) {
            $recommendations[] = [
                'indicator' => 'News Sentiment',
                'level' => 'MEDIUM',
                'recommendation' => 'Monitor regional news and potential disruptions affecting logistics.',
            ];
        }

        if ($riskScore->port_score >= 60) {
            $recommendations[] = [
                'indicator' => 'Port Infrastructure',
                'level' => 'HIGH',
                'recommendation' => 'Identify alternative ports and diversify maritime logistics routes.',
            ];
        } elseif ($riskScore->port_score >= 30) {
            $recommendations[] = [
                'indicator' => 'Port Infrastructure',
                'level' => 'MEDIUM',
                'recommendation' => 'Evaluate alternative ports to reduce dependency on limited infrastructure.',
            ];
        }

        if (empty($recommendations)) {
            $recommendations[] = [
                'indicator' => 'Overall Risk',
                'level' => 'LOW',
                'recommendation' => 'Current supply chain risk is relatively low. Continue regular monitoring.',
            ];
        }

        return $recommendations;
    }
}
