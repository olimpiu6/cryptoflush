<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StoreCoinsMarketData;

class Test extends AbstractController
{
    /**
     * @Route("/test", name="muser")
     */
    public function test(): Response{
       /* $rss = new StoreRssData('https://cryptonews.com/news/feed', 
                                $this->getDoctrine()->getManager());
        $rss->rssToDatabase();*/

        /*$rates = new StoreBtcRatesData($this->getDoctrine()->getManager());
        $rates->saveRatesData();*/
        /*$rates = new StoreCoinsMarketData($this->getDoctrine()->getManager());
        $rates->saveData();*/

        $j = '[]';
        $j = \json_decode($j, true);
        var_dump($j);

        return new Response('<p>********fin de respuesta*********</p>');
    }
}