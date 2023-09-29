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
    name: 'currency:convert',
    description: 'Convert currency values',
)]
class CurrencyConverterCommand extends Command
{
    public function __construct(protected CurrencyConverterService $service)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Convert Currencies')
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount to convert')
            ->addArgument('from', InputArgument::REQUIRED, 'Original currency (AUD, USD)')
            ->addArgument('to', InputArgument::REQUIRED, 'Currency to convert into');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $amount = $input->getArgument('amount');
        $from = strtoupper($input->getArgument('from'));
        $to = strtoupper($input->getArgument('to'));

        try {
            $convertedAmount = $this->service->convert($amount, $from, $to);

            $output->writeln("Succesfully converted your currency. $amount $from = $convertedAmount in $to");

            $this->service->writeToCsv($amount, $from, $convertedAmount, $to);

            return Command::SUCCESS;

        } catch (InvalidArgumentException $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
