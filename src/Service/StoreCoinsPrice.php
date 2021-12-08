<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\CoinsPrice;
use App\Entity\Coins;
use App\Service\CoingeckoApi;

class StoreCoinsPrice{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * process array of coin price data
     * insert or update data in the database, coins_price table
     * uses array with data
     */
    public function processCoinPriceData($price_data, $vs_currency){
        if(\is_array($price_data)){
            //loop price data array, create or update price data
            foreach($price_data as $k => $v){
                //coins repository 
                $coin_repo = $this->em->getRepository(Coins::class);
                //fetch coin data, name, symbol, etc
                $coin = $coin_repo->findOneBy(['idTicker'=>$k]);

                //coin prices repository 
                $coin_price = $this->em->getRepository(CoinsPrice::class);

                //if coin check if price allready exists, update, insert if none exists
                if($coin){
                    //fetch coin price data
                    $coin_pr = $coin_price->findOneBy(['ticker'=>$coin->getIdTicker()]);
                    
                    //get default usd values for market_cap, 24h_vol, 24h_change
                    $usd_market_cap = isset($v['usd_market_cap']) ? $v['usd_market_cap'] : 0;
                    $usd_24h_vol = isset($v['usd_24h_vol']) ? $v['usd_24h_vol'] : 0;
                    $usd_24h_change = isset($v['usd_24h_change']) ? $v['usd_24h_change'] : 0;

                    //if $coin_pr update existing values with the new ones
                    if($coin_pr){
                        //update values
                        $coin_pr->setVsCurrencies(\explode(',', $vs_currency));
                        $coin_pr->setMarketCap($usd_market_cap);
                        $coin_pr->setDayVolume($usd_24h_vol);
                        $coin_pr->setDayChange($usd_24h_change);
                        $coin_pr->setRawData($v);

                        //persist data, flush, unset rep object
                        $this->em->flush();
                        unset($coin_pr);
                        continue;
                    //if no value is found asume there is no data, new coin added
                    }else{
                        //new coin prices object
                        $cp = new CoinsPrice();

                        $cp->setName($coin->getName());
                        $cp->setTicker($coin->getSymbol());
                        $cp->setVsCurrencies(\explode(',', $vs_currency));
                        $cp->setMarketCap($usd_market_cap);
                        $cp->setDayVolume($usd_24h_vol);
                        $cp->setDayChange($usd_24h_change);
                        $cp->setRawData($v);

                        //persist and flush
                        $this->em->persist($cp);
                        $this->em->flush();
                        unset($cp);
                    }


                }
            }
        }
    }

    /**
     * stores coin prices
     * uses the idTicker and symbol from coins entity to identify the coin
     * no relation with coins entity, possible change un the future
     */
    public function storePrices(){
        //coingecko api data object
        $cg = new CoingeckoApi();

        //price data, variable to store the data from the api
        $price_data = '';

        //vs_currency list
        $vs_currency = 'usd,eur,jpy';

        //coins repository object, selects all coins
        $coins_repo = $this->em->getRepository(Coins::class);
        $coin_list = $coins_repo->findAll();

        //check list has results
        if(\is_array($coin_list)){
            //split coin_list in chunks of 200 elements
            $chunked_list = \array_chunk($coin_list, 200);
            $ct = 0;

            //set time limit for current script to infinite
            set_time_limit(0);

            foreach($chunked_list as $k => $v){
                //coins ticker, id
                $coins_ticker = '';

                //process each portion of the chunked array
                foreach($v as $key => $val){
                    //generate coins id, ticker list, concat string with ticker from coins entity
                    $coins_ticker .= $val->getIdTicker() . ',';
                }
                
                //get price data from api
                $price_data = $cg->coinsPrice(array('ids'=> $coins_ticker,
                                                    'vs_currencies' => $vs_currency,
                                                    'include_market_cap' => 'true',
                                                    'include_24hr_vol' => 'true',
                                                    'include_24hr_change' => 'true',
                                                    'include_last_updated_at' => 'false'));
                
                //store coin data
                $this->processCoinPriceData($price_data, $vs_currency);
                //sleep for two seconds
                \sleep(2);
            }
        }
        return true; 
    }
//end of class
}