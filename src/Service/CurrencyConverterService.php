<?php

namespace App\Service;

class CurrencyConverterService
{
    public function __construct(private array $rates)
    {
    }
    public function getConversionRate(string $from, string $to)
    {
        return $this->rates[$from][$to] ?? null;
    }

    public function convert(float $amount, string $from, string $to)
    {
        $conversionRate = $this->getConversionRate($from, $to);
        if($conversionRate === null) {
            throw new InvalidArgumentException("Unsupported currency type.");
        }

        return $amount * $conversionRate;
    }
}
