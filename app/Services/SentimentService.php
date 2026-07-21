<?php

namespace App\Services;

use App\Models\PositiveWord;
use App\Models\NegativeWord;

class SentimentService
{
    public function analyze($text)
    {
        $text = strtolower(strip_tags($text));

        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);

        $words = explode(' ', $text);

        $positiveWords = PositiveWord::pluck('word')->toArray();

        $negativeWords = NegativeWord::pluck('word')->toArray();

        $positiveScore = 0;

        $negativeScore = 0;

        foreach ($words as $word) {

            if (in_array($word, $positiveWords)) {

                $positiveScore++;

            }

            if (in_array($word, $negativeWords)) {

                $negativeScore++;

            }

        }

        if ($positiveScore > $negativeScore) {

            $sentiment = 'Positive';

        } elseif ($negativeScore > $positiveScore) {

            $sentiment = 'Negative';

        } else {

            $sentiment = 'Neutral';

        }

        return [

            'positive' => $positiveScore,

            'negative' => $negativeScore,

            'sentiment' => $sentiment

        ];
    }
}