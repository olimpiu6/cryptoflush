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
        //coin ticker result paginator
        $coinPaginator = 0;

        //flag for the loop control
        $loopControl = true;

        //coingecko api object
        $cg = new CoingeckoApi();

        //get some tickers coin market repository
        $coinrepo = $this->em->getRepository(CoinMarketsData::class);

        //chart data repo
        $chartrepo = $this->em->getRepository(CoinDailyChart::class);

        while($loopControl){
            $tickers = $coinrepo->findLimitTickers($coinPaginator, 30);
            
            //check if some results are found
            if(is_array($tickers) && \count($tickers) > 0){
                //loop through results and create/update chart data
                foreach($tickers as $k => $v){
                    //get data from api
                    $data = $cg->coinsChart(array(
                                               
                                                'vs_currency' => 'usd',
                                                'days' => 'max'
                                                ),
                                            $v['coin_ticker']);
                    //check if data is array, insert/update values in chart table
                    if(\is_array($data) && \count($data) > 0){
                        //try to find chart data 
                        $ch = $chartrepo->findOneBy(['coinTicker'=>$v['coin_ticker']]);
                        if(!$ch){
                            $this->createChartData($data, $v['coin_ticker']);
                        }else{
                            $this->updateChartData($ch,$data);
                        }

                    }
                }
            }else{
                //break the loop
                $loopControl = false;
                break;
            }

            //increase paginator by some amount, to get next chunk of tickers
            $loopControl = false;
            $coinPaginator += 30;
            
        }
    }

}