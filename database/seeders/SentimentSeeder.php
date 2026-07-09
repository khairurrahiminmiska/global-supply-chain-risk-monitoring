<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

class SentimentSeeder extends Seeder
{
    public function run(): void
    {

        $positive = [

            'growth',
            'increase',
            'improve',
            'stable',
            'profit',
            'success',
            'recovery',
            'export',
            'development',
            'investment',
            'efficient',
            'expansion',
            'boost',
            'opportunity'

        ];

        foreach($positive as $word){

            PositiveWord::create([
                'word'=>$word
            ]);

        }

        $negative = [

            'war',
            'crisis',
            'inflation',
            'delay',
            'storm',
            'conflict',
            'decline',
            'loss',
            'disaster',
            'recession',
            'earthquake',
            'flood',
            'shortage',
            'risk'

        ];

        foreach($negative as $word){

            NegativeWord::create([
                'word'=>$word
            ]);

        }

    }
}