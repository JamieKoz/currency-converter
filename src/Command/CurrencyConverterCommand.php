<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'currency:converter',
    description: 'Add a short description for your command',
)]
class CurrencyConverterCommand extends Command
{
    public function __construct()
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
        $from = $input->getArgument('from');
        $to = $input->getArgument('to');
        dd($amount, $from, $to);
        //
        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }
        //
        // if ($input->getOption('option1')) {
        //     // ...
        // }
        //
        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
