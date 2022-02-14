<?php
namespace App\Service;

use App\Entity\CoinMarketsData;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\CurlMaker;

class StoreCoinsMarketData{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
        //set time limit for current script to infinite
        set_time_limit(0);
    }

    /**
     * create new coin market data entry on database
     * @param $coinData coingecko, or other array with data from any api endpoint
     */
    public function createCoinData($coinData){
        $coin = new CoinMarketsData();

        $coin->setCoinTicker($coinData['id']);
        $coin->setSymbol($coinData['symbol']);
        $coin->setString($coinData['image']);
        $coin->setCurrentPrice($coinData['current_price']);
        $coin->setMarketCap($coinData['market_cap']);
        $coin->setMarketCapRank($coinData['market_cap_rank']);
        $coin->setTotalVolume($coinData['total_volume']);
        $coin->setDailyLow($coinData['low_24h']);
        $coin->setDailyHigh($coinData['high_24h']);
        $coin->setDailyPriceChange($coinData['price_change_24h']);
        $coin->setDailyPriceChangePercentage($coinData['price_change_percentage_24h']);
        $coin->setDailyMarketCapChange($coinData['market_cap_change_24h']);
        $coin->setDailyMarketCapChangePercentage($coinData['market_cap_change_percentage_24h']);
        $coin->setCirculatingSupply((int)$coinData['circulating_supply']);
        $coin->setTotalSupply((int)$coinData['total_supply']);
        $coin->setMaxSupply((int)$coinData['max_supply']);
        $coin->setJsonData($coinData);

        //persist market data to data base
        $this->em->persist($coin);
        $this->em->flush();
        unset($coin);
    }

    /**
     * update coin market data for specific coin
     * @param $coinTicker coin id, coin unique simbol, retrieve from api data
     * @param $coin coin market data object, doctrine object
     * @param $coinData coin data array from api array data
     */
    public function updateCoinData($coin, $coinData){

        $coin->setCoinTicker($coinData['id']);
        $coin->setSymbol($coinData['symbol']);
        $coin->setString($coinData['image']);
        $coin->setCurrentPrice($coinData['current_price']);
        $coin->setMarketCap($coinData['market_cap']);
        $coin->setMarketCapRank($coinData['market_cap_rank']);
        $coin->setTotalVolume($coinData['total_volume']);
        $coin->setDailyLow($coinData['low_24h']);
        $coin->setDailyHigh($coinData['high_24h']);
        $coin->setDailyPriceChange($coinData['price_change_24h']);
        $coin->setDailyPriceChangePercentage($coinData['price_change_percentage_24h']);
        $coin->setDailyMarketCapChange($coinData['market_cap_change_24h']);
        $coin->setDailyMarketCapChangePercentage($coinData['market_cap_change_percentage_24h']);
        $coin->setCirculatingSupply((int)$coinData['circulating_supply']);
        $coin->setTotalSupply((int)$coinData['total_supply']);
        $coin->setMaxSupply((int)$coinData['max_supply']);
        $coin->setJsonData($coinData);

        //persist market data to data base
        //$this->em->persist($coin);
        $this->em->flush();
        unset($coin);
    }

    /**
     * get data from api end point
     * try to save to database
     */
    public function saveData(){
        //api data paginator
        $api_data_page = 1;
        /**
         *  loop through api data controller variable
         *  set to false when no more data availables on api endpoint
         */ 
        $loop_control = true;

        //coingecko api object
        $cg = new CoingeckoApi();

        //coin market data repository 
        $repo = $this->em->getRepository(CoinMarketsData::class);

        /**
         * loop through coingeko api data
         * store data to db as it loops
         */
        while($loop_control){
            //get data from api end point, use pagination if necesary
            $data = $cg->coinMarkets(
                array(
                    'vs_currency' => 'usd', 
                    'ids' => null, 
                    'order' => 'market_cap_desc', 
                    'per_page' => 250, 
                    'page' => $api_data_page, 
                    'sparkline' => true, 
                    'price_change_percentage'=> '7d,30d,1y'
                )
            );

            if($data && \is_array($data)){
                //break loop if enpty array is received
                if(count($data) == 0){
                    break;
                }
                
                foreach($data as $k=>$v){
                    /**
                     * check if coin already exists
                     * update if coin is found
                     * insert if not
                     */
                    //check if coin already exists
                    $coin = $repo->findOneBy(['coinTicker'=>$v['id']]);

                    if(!$coin){
                        $this->createCoinData($v);
                    }else{
                        $this->updateCoinData($coin, $v);
                    }
                }
            }else{
                //end loop, change $loop_control to false
                $loop_control = false;
            }

        //increase api pagination by one
        $api_data_page += 1;
        \sleep(2);
        }//end loop
    }

}