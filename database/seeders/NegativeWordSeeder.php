<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NegativeWordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            'crisis', 'recession', 'decline', 'collapse', 'deficit',
            'inflation', 'unemployment', 'poverty', 'instability', 'volatility',
            'default', 'bankruptcy', 'downturn', 'slowdown', 'stagnation',
            'loss', 'debt', 'deficit', 'shortage', 'scarcity',
            'disaster', 'conflict', 'sanction', 'tariff', 'embargo',
            'protest', 'strike', 'disruption', 'delay', 'bottleneck',
            'corruption', 'scandal', 'fraud', 'mismanagement', 'inefficiency',
            'devaluation', 'depreciation', 'downgrade', 'unstable', 'uncertainty',
            'tension', 'threat', 'risk', 'danger', 'warning',
            'flood', 'drought', 'storm', 'earthquake', 'pandemic',
            'disease', 'outbreak', 'lockdown', 'restriction', 'shortfall',
            'cut', 'reduction', 'layoff', 'furlough', 'shutdown',
            'contamination', 'pollution', 'spill', 'accident', 'violation',
            'penalty', 'lawsuit', 'investigation', 'overhaul', 'recall',
            'declining', 'dropping', 'falling', 'worsening', 'deteriorating',
            'critical', 'severe', 'extreme', 'emergency', 'alarming',
        ];

        foreach ($words as $word) {
            DB::table('negative_words')->updateOrInsert(
                ['word' => $word],
                ['word' => $word, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
