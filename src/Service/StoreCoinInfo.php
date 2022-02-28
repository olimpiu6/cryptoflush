<?php
namespace App\Service;

use App\Entity\CoinInfo;
use App\Entity\CoinMarketsData;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\CurlMaker;

class StoreCoinInfo{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
        //set time limit for current script to infinite
        set_time_limit(0);
    }

    /**
     * create new db entry with data from some json api
     * @param $coinData 
     * @param $coinTicker
     */
    public function createInfoData($coinData, $coinTicker){
        $chartData = new CoinInfo();

        $chartData->setLang('en');
        $chartData->setJsonData($coinData);
        $chartData->setTicker($coinTicker);

        //persist market data to data base
        $this->em->persist($chartData);
        $this->em->flush();
        unset($chartData);
    }

    /**
     * update chart data values, only json
     * @param $chartDataObj
     * @param $jsonData
     */
    public function updateInfoData($chartDataObj, $jsonData){
        $chartDataObj->setJsonData($jsonData);

        $this->em->flush();
        unset($chartDataObj);
    }

    /**
     * store, update chart data
     * selects ticker from db, stores in chuncks
     */
    public function storeData(){
        
        //coingecko api object
        $cg = new CoingeckoApi();

        //get some tickers coin market repository
        $coinrepo = $this->em->getRepository(CoinMarketsData::class);
        //get all tickers 
        $tickers = $coinrepo->findAllTickers();

        //chart data repo
        $coinInforepo = $this->em->getRepository(CoinInfo::class);

        //loop and save data
        for($i = 0; $i < count($tickers); $i++){
            //get data from api server
            $data = $cg->coinTechInfo(array(
                'id'=> $tickers[$i]['coin_ticker'],
                'localization' => false,
                'tickers' => false,
                'market_data' => false,
                'community_data' => true,
                'developer_data' => true,
                'sparkline' => false
                ),
            $tickers[$i]['coin_ticker']);

            //check if data is array, insert/update values in chart table
            if(\is_array($data) && \count($data) > 0){
                //try to find chart data 
                $ch = $coinInforepo->findOneBy(['ticker'=>$tickers[$i]['coin_ticker']]);
                if(!$ch){
                    $this->createInfoData($data, $tickers[$i]['coin_ticker']);
                }else{
                    $this->updateInfoData($ch, $data);
                }

            }

            //sleep 2 sec every 30 results
            if($i > 0 && $i % 30 == 0){
                \sleep(2);
            }
            //\usleep(200);
        }
    }

}