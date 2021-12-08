<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\StoreCoinsPrice;

class UpdateCoinsPrices extends Command{

    //StoreCoinsPrice object
    private $storeprices;

    protected static $defaultName = 'app:update:coins:prices';

    public function __construct(StoreCoinsPrice $storeprices){
        $this->storeprices = $storeprices;

        parent::__construct();
    }

    protected function configure(){

        $this
            ->setDescription('Update coins prices')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int{
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $this->storeprices->storePrices();
        }else{
            $this->storeprices->storePrices();
        }

        $io->success(sprintf("Done updating prices \n"));

        return 0;
    }
}