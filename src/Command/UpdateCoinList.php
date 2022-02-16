<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\StoreCoinsData;

class UpdateCoinList extends Command{

    //StoreCoinsPrice object
    private $storeprices;

    protected static $defaultName = 'app:update:coins:list';

    public function __construct(StoreCoinsData $storeprices){
        $this->storeprices = $storeprices;

        parent::__construct();
    }

    protected function configure(){

        $this
            ->setDescription('Update coins list')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int{
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $this->storeprices->saveCoinsData();
        }else{
            $this->storeprices->saveCoinsData();
        }

        $io->success(sprintf("Done updating coin list \n"));

        return 0;
    }
}