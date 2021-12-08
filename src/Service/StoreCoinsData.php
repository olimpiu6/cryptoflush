<?php
namespace App\Service;

use App\Entity\CoinMarketsData;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\CurlMaker;

class StoreCoinsData{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * get data from api end point
     */
    public function saveCoinsData(){
        //coingecko data
        $cg = new CoingeckoApi();
        $data = $cg->coinLIst(true);
        //\var_dump($data);

        //check if data is array, loop and insert
        if(\is_array($data)){
            if(\count($data) > 0){
                foreach($data as $k => $v){
                    //coin repository 
                    $coin_repo = $this->em->getRepository(Coins::class);

                    $r = $coin_repo->findOneBy(['name'=>$v['name']]);

                    //check if this coin exists, create if not
                    if(!$r){
                        $coin = new Coins();

                        //check if platform has data
                        $platform = \is_array($v['platforms']) ? $v['platforms'] : null;
                        $platform = !\is_null($platform) ? \json_encode($platform) : null;
                        
                        $coin->setIdTicker($v['id']);
                        $coin->setSymbol($v['symbol']);
                        $coin->setName($v['name']);
                        $coin->setPlatform($platform);
                        //$coin->setAddress($k);

                        $this->em->persist($coin);
                        $this->em->flush();
                        unset($coin);
                    }
                }
            }
            return true;
        }

        return false;
    }


}