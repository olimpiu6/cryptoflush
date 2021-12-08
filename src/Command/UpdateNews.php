<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\StoreRssData;
use App\Entity\RssFeed;

class UpdateNews extends Command{

    private $entityManager;

    protected static $defaultName = 'app:update:news';

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(){

        $this
            ->setDescription('Update coins prices')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
        ;
    }

    /**
     * update rss url data 
     */
    public function updateData(){
        $em = $this->entityManager;
        //create new RssFeed doctrine object, or something like that
        $repository = $em->getRepository(RssFeed::class);

        //search for active feeds in the db
        $feeds = $repository->findBy(['active'=>1]);

        //loop throught all objects
        if(\is_array($feeds)){
            foreach($feeds as $key=>$val){
                $rss = new StoreRssData($val->getUrl(), $em);
                $rss->rssToDatabase();

                //wait one sec
                \sleep(1);
            }
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int{
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $this->updateData();
        }else{
            $this->updateData();
        }

        $io->success(sprintf("Done updating news \n"));

        return 0;
    }
}