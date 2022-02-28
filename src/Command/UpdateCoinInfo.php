<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\StoreCoinInfo;
use App\Entity\CoinInfo; 

class UpdateCoinInfo extends Command{

    private $entityManager;

    protected static $defaultName = 'app:update:coininfo';

    public function __construct(EntityManagerInterface $entityManager){
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(){

        $this->setDescription('Update coins info')->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run');
    }

    /**
     * update market data
     */
    public function updateData(){
        $em = $this->entityManager;
        //create new CoinMarketsData doctrine object, or something like that
        $repository = $em->getRepository(CoinInfo::class);

        $mk = new StoreCoinInfo($em);
        $mk->storeData();
        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int{
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $this->updateData();
        }else{
            $this->updateData();
        }

        $io->success(sprintf("Done updating coins info \n"));

        return 0;
    }
}