<?php
namespace App\Service;

use App\Service\CurlMaker;

class CoingeckoApi{

    protected $endPoints;
    protected $apiUrl;
    protected $header;

    /**
     * constructor
     */
    public function __construct(){
        $this->setEndPoints();
        $this->setApiUrl();
        $this->setHeader();
    }

    /**
     * setter, getter
     */
    public function setEndPoints(){
        $this->endPoints = array(
            'exchange_rates'    => 'exchange_rates',
            'coins/list'        => 'coins/list',
            'coins/markets'     => 'coins/markets',
            'simple/price'      => 'simple/price',
            'coin/market_chart' => 'coins/{id}/market_chart'
        );

        return $this;
    }

    public function getEndPoints(){
       return $this->endPoints; 
    }  

    public function setApiUrl(){
        $this->apiUrl = 'https://api.coingecko.com/api/v3/';

        return $this;
    }

    public function getApiUrl(){
       return $this->apiUrl; 
    } 

    public function setHeader(){
        $this->header = 'accept: application/json';

        return $this;
    } 

    public function getHeader(){
        return $this->header;
    } 

    /**
     * JSON to array
     * try to decode json response if posible, convert to array
     */
    private function jsonToArray($json_string){
        //try to decode json string
        $data = \json_decode($json_string, true);

        //check for errors and return 
        return \json_last_error() === JSON_ERROR_NONE ? $data : null;
    }

    /**
     * full resource url
     * generates the full url for a given resource
     */
    public function makeUrl($end_points = '', $flag = '', $ticker = ''){
        $endp = \preg_replace('/{id}/', $ticker, $end_points);
        $url = $this->apiUrl . $endp . $flag;

        return $url;
    }

    /**
     * make flag param string from array
     * flags are the url params, Ex: ?id=bitcoin&vs=usd&per-page=100...etc
     */
    public function makeParam($flag){
        //set the flags
        $flags = '';
        if(\is_array($flag)){
            foreach($flag as $k => $v){
                /**
                 * check for booleans params
                 * convert to string true : false instead of int 0 : 1
                 */
                if(\is_bool($v)){
                    $v = $v === true ? 'true' : 'false';
                }
                /*
                * if not null set as url param: &$k=$v
                * check if it is the first param to add ? to url: ?$k=$v
                */
                if(!\is_null($v)){
                    //check if first param
                    if($flags == ''){
                        $flags .= '?' . $k . '=' .$v;
                        continue;
                    }
                    //if not first param add & separator
                    $flags .= '&' . $k . '=' .$v;
                } 
            }//end loop
        }//end if
        
        return $flags;
    }

    /**
     * get resource data
     */
    public function getResourceData($url){
        //conect and get api response
        $apiResponse = CurlMaker::getFromUrl($url, $this->getHeader());

        return $apiResponse;
    }

    /**
     * get BTC rates
     */
    public function btcRates(){
        //conect and get api response
        $apiResponse = $this->getResourceData( $this->makeUrl($this->endPoints['exchange_rates']) );

        //check for errors and return 
        return $this->jsonToArray($apiResponse);
    }

    /**
     * get full coins listS
     */
    public function coinLIst($flag = false){
        //set the flat
        $flag = $flag === false ? '' : '?include_platform=true';

        //conect and get api response
        $apiResponse = $this->getResourceData( $this->makeUrl($this->endPoints['coins/list'], $flag) );

        //check for errors and return 
        return $this->jsonToArray($apiResponse);
    }

    /**
     * get coin markets data, price , volume, change, 
     * 
     * FLAGS, URL PARAMS
     *  vs_currency=usd
     *  ids=bitcoin
     *  order=market_cap_desc  market_cap_desc, gecko_desc, gecko_asc, market_cap_asc, market_cap_desc, volume_asc, volume_desc, id_asc, id_desc
     *  per_page=100
     *  page=1
     *  sparkline=true
     *  price_change_percentage=1y 
     */
    public function coinMarkets( $flag = array(
                                    'vs_currency' => null, 
                                    'ids' => null, 
                                    'order' => null, 
                                    'per_page' => null, 
                                    'page' => null, 
                                    'sparkline' => true, 
                                    'price_change_percentage'=> null
                                )){

        //set the flags
        $flags = $this->makeParam($flag);;

        //conect and get api response
        $apiResponse = $this->getResourceData( $this->makeUrl($this->endPoints['coins/markets'], $flags) );
        
        //check for errors and return 
        return $this->jsonToArray($apiResponse);
    }

    /**
     * get coin price
     * 
     * ids comma separated coin ticker, id
     * vs_currencias comma separated list of currencies: usd, eur, eth... etc
     * include_market_cap boolean
     * include_24hr_change boolean
     * include_last_updated_at boolean boolean, default false
     */
    public function coinsPrice($flag = array(
                                    'ids' => null,
                                    'vs_currencies' => null,
                                    'include_market_cap' => null,
                                    'include_24hr_vol' => null,
                                    'include_24hr_change' => null,
                                    'include_last_updated_at' => null
                                )){
        //set the flags
        $flags = $this->makeParam($flag);;

        //conect and get api response
        $apiResponse = $this->getResourceData( $this->makeUrl($this->endPoints['simple/price'], $flags) );

        //check for errors and return 
        return $this->jsonToArray($apiResponse);
    }

    /**
     * get coin chart daily data, searches for all data
     * 
     * vs_currency : usd... etc
     * days: number of days 1,2,365,max..
     */
    public function coinsChart($flag = array('id'=> null,
                                        'vs_currency' => null,
                                        'days' => null),
                                $ticker){
        //set the flags
        $flags = $this->makeParam($flag);;

        //conect and get api response
        $apiResponse = $this->getResourceData( $this->makeUrl($this->endPoints['coin/market_chart'], $flags, $ticker) );
        //echo ($this->makeUrl($this->endPoints['coin/market_chart'], $flags, $ticker)) . '<br>';
        //check for errors and return 
        return $this->jsonToArray($apiResponse);

    }

//class end
}