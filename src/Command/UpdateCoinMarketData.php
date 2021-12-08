<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\StoreCoinsMarketData;
use App\Entity\CoinMarketsData; 

class UpdateCoinMarketData extends Command{

    private $entityManager;

    protected static $defaultName = 'app:update:marketdata';

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(){

        $this
            ->setDescription('Update coins market data')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
        ;
    }

    /**
     * update market data
     */
    public function updateData(){
        $em = $this->entityManager;
        //create new CoinMarketsData doctrine object, or something like that
        $repository = $em->getRepository(CoinMarketsData::class);

        $mk = new StoreCoinsMarketData($em);
        $mk->saveData();
        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int{
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $this->updateData();
        }else{
            $this->updateData();
        }

        $io->success(sprintf("Done updating market data \n"));

        return 0;
    }
}