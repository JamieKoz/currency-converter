<?php

namespace App\Service;

class CurrencyConverterService
{
    public function __construct(protected array $rates, protected string $csvFilePath)
    {
    }

    public function getConversionRate(string $from, string $to): ?float
    {
        return $this->rates[$from][$to] ?? null;
    }

    public function convert(float $amount, string $from, string $to): float
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

    public function calculateProfitFromCsv(): float
    {
        if(!file_exists($this->csvFilePath)) {
            throw new \RuntimeException('Could not find CSV file.');
        }

        $rows = array_map('str_getcsv', file($this->csvFilePath));
        array_shift($rows);

        $totalProfit = 0;

        foreach ($rows as $row) {
            [$initial, $converted] = $row;

            $initialValue = (float)explode(' ', $initial)[0];
            $initialCurrency = explode(' ', $initial)[1];
            $convertedValue = (float)explode(' ', $converted)[0];
            $convertedCurrency = explode(' ', $converted)[1];

            if ($initialCurrency === 'AUD') {
                $foreignProfit = $convertedValue * 0.15;
                $profit = $foreignProfit * ($this->getConversionRate($convertedCurrency, 'AUD') ?? 1);
            } elseif ($convertedCurrency === 'AUD') {
                $profit = ($convertedValue * 0.15);
            } else {
                $profit = 0;
            }

            $totalProfit += $profit;
        }

        return $totalProfit;
    }
}
