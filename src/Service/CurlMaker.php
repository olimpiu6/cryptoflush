<?php
namespace App\Service;

class CurlMaker{

    /**
     * get data from some url, intents to connect, read, and return raw data, no validation,
     * and no regurgitation
     */
    public static function getFromUrl(string $url, $header = null){
        $curl = \curl_init();

        \curl_setopt($curl, CURLOPT_URL, $url);
        \curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //check if header value is not null
        if(!\is_null($header)){
            \curl_setopt($curl, CURLOPT_HTTPHEADER, array($header));
        }

        $response = \curl_exec($curl);
        \curl_close($curl);

        return $response;
    }
}