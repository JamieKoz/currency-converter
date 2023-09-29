<?php

namespace App\Service;

class CurrencyConverterService
{
    public function __construct(private array $rates, protected string $csvFilePath)
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

    public function writeToCsv(float $initialAmount, string $initialCurrency, float $convertedAmount, string $convertedCurrency): void
    {
        $file = fopen($this->csvFilePath, 'a');
        if ($file === false) {
            throw new \RuntimeException('Failed to open the CSV file for writing.');
        }

        $data = [
            $initialAmount . ' ' . $initialCurrency,
            $convertedAmount . ' ' . $convertedCurrency
        ];

        if(filesize($this->csvFilePath === 0)) {
            fputcsv($file, ['Initial Amount', 'Converted Amount']);
        }

        fputcsv($file, $data);
        fclose($file);
    }
}
