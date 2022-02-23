<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\StoreDailyChartData;
use App\Entity\CoinDailyChart; 

class UpdateDailyChart extends Command{

    private $entityManager;

    protected static $defaultName = 'app:update:dailychart';

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(){

        $this->setDescription('Update coins falily chart data')->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run');
    }

    /**
     * update market data
     */
    public function updateData(){
        $em = $this->entityManager;
        //create new CoinMarketsData doctrine object, or something like that
        $repository = $em->getRepository(CoinDailyChart::class);

        $mk = new StoreDailyChartData($em);
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

        $io->success(sprintf("Done updating market data \n"));

        return 0;
    }
}