<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\CurrencyConverterService;

#[AsCommand(
    name: 'calculate:profit',
    description: 'Calculate 15% profit for conversion total amount',
)]
class CalculateProfitCommand extends Command
{
    public function __construct(protected CurrencyConverterService $service)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Calculate the profit using the currency conversion transaction in the csv.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $totalProfit = $this->service->calculateProfitFromCsv();

        $io->success("Total Profit in AUD: $totalProfit AUD");

        return Command::SUCCESS;
    }
}
