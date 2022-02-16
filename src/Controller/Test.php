<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StoreDailyChartData;

class Test extends AbstractController
{
    /**
     * @Route("/test", name="muser")
     */
    public function test(): Response{
        $t1 = \date('H:i:s', time());
        $d = new StoreDailyChartData($this->getDoctrine()->getManager());
        $d->storeData();
        $t2 = \date('H:i:s', time());
       /* $rss = new StoreRssData('https://cryptonews.com/news/feed', 
                                $this->getDoctrine()->getManager());
        $rss->rssToDatabase();*/

        /*$rates = new StoreBtcRatesData($this->getDoctrine()->getManager());
        $rates->saveRatesData();*/
        /*$rates = new StoreCoinsMarketData($this->getDoctrine()->getManager());
        $rates->saveData();*/

        /*$j = '[]';
        $j = \json_decode($j, true);
        var_dump($j);*/
        $r = '<p>'.$t1 . '<br>'. $t2.'</p>';
        return new Response($r);
    }
}