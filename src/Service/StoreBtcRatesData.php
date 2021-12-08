<?php
namespace App\Service;

use App\Entity\BtcExchangeRates;
use Doctrine\ORM\EntityManagerInterface;

class StoreBtcRatesData{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * get data from api end point
     */
    public function saveRatesData(){
        //coingecko data
        $cg = new CoingeckoApi();
        $data = $cg->btcRates();
        //\var_dump($data);

        //check if data is array, loop and insert or update
        if(\is_array($data['rates'])){
            if(\count($data['rates']) > 0){
                foreach($data['rates'] as $k => $v){
                    //rates repository 
                    $rates_repo = $this->em->getRepository(BtcExchangeRates::class);

                    $r = $rates_repo->findOneBy(['name'=>$v['name']]);

                    //check if this rate exists and update
                    if($r){
                        $r->setValue($v['value']);

                        //persist post data
                        //$this->em->persist($rates);
                        $this->em->flush();
                        unset($r);
                        continue;
                    }else{
                        $rates = new BtcExchangeRates();
                        
                        $rates->setName($v['name']);
                        $rates->setUnit($v['unit']);
                        $rates->setValue($v['value']);
                        $rates->setType($v['type']);
                        $rates->setSymbol($k);

                        $this->em->persist($rates);
                        $this->em->flush();
                        unset($rates);
                    }
                    
                }
            }
            return true;
        }

        return false;
    }


}