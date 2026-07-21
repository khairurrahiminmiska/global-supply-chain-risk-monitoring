<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositiveWordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            'growth', 'stable', 'profit', 'success', 'positive',
            'strong', 'recovery', 'expansion', 'boom', 'prosperity',
            'surplus', 'gain', 'improvement', 'increase', 'rise',
            'boost', 'flourish', 'thrive', 'advance', 'progress',
            'innovation', 'breakthrough', 'opportunity', 'efficient', 'sustainable',
            'investment', 'infrastructure', 'development', 'modernization', 'upgrade',
            'trade', 'export', 'import', 'production', 'supply',
            'demand', 'output', 'capacity', 'productivity', 'efficiency',
            'partnership', 'cooperation', 'agreement', 'alliance', 'collaboration',
            'reform', 'deregulation', 'liberalization', 'privatization', 'diversification',
            'technology', 'digital', 'automation', 'logistics', 'connectivity',
            'confidence', 'optimism', 'momentum', 'resilience', 'competitive',
            'leading', 'pioneer', 'milestone', 'record', 'achievement',
            'benefit', 'advantage', 'potential', 'promising', 'favorable',
        ];

        foreach ($words as $word) {
            DB::table('positive_words')->updateOrInsert(
                ['word' => $word],
                ['word' => $word, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
