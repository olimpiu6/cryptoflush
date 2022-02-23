<?php
namespace App\Service;

use App\Entity\CoinDailyChart;
use App\Entity\CoinMarketsData;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\CurlMaker;

class StoreDailyChartData{

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
    public function createChartData($coinData, $coinTicker){
        $chartData = new CoinDailyChart();

        $chartData->setCoinTicker($coinTicker);
        $chartData->setVsCurrency('usd');
        $chartData->setJsonData($coinData);

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
    public function updateChartData($chartDataObj, $jsonData){
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
        $chartrepo = $this->em->getRepository(CoinDailyChart::class);

        //loop and save data
        for($i = 0; $i < count($tickers); $i++){
            //get data from api server
            $data = $cg->coinsChart(array(
                'vs_currency' => 'usd',
                'days' => 'max'
                ),
            $tickers[$i]['coin_ticker']);

            //check if data is array, insert/update values in chart table
            if(\is_array($data) && \count($data) > 0){
                //try to find chart data 
                $ch = $chartrepo->findOneBy(['coinTicker'=>$tickers[$i]['coin_ticker']]);
                if(!$ch){
                    $this->createChartData($data, $tickers[$i]['coin_ticker']);
                }else{
                    $this->updateChartData($ch, $data);
                }

            }

            //sleep every 30 results
            if($i > 0 && $i % 30 == 0){
                sleep(2);
            }
        }
    }

}