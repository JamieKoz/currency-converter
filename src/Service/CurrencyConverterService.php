<?php

namespace App\Service;

class CurrencyConverterService
{
    public function getConversionRate(string $from, string $to)
    {
        $rates = [
         'AUD' => ['USD' => 1 / 1.5, 'NZD' => 1 / 0.9, 'GBP' => 1 / 1.7, 'EUR' => 1 / 1.5],
                'USD' => ['AUD' => 1.5],
                'NZD' => ['AUD' => 0.9],
                'GBP' => ['AUD' => 1.7],
                'EUR' => ['AUD' => 1.5]
            ];
        return $rates[$from][$to] ?? null;
    }
}
