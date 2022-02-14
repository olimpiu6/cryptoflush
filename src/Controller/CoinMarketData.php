<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CoinMarketsData;

class CoinMarketData extends AbstractController{

    /**
     * @Route("/crypto/{pag}", name="crypto")
     */
    public function showCoinList(int $pag = 1): Response{
        //CoinsPrice repository object
        $repository = $this->getDoctrine()->getRepository(CoinMarketsData::class);
        $offset = $pag ==  1 ? 0 : ($pag-1) * 100;
        //get price list 
        $market_data = $repository->findLimit($offset, 100);

        //js,css plugins for this page
        $jsplugin = array('datatables');
        $cssplugin = array('datatables');

        return $this->render('public/coins_market_data.html.twig', [
                                'market_data'=>$market_data,
                                'pag'=>$pag,
                                'jsplugin'=>$jsplugin,
                                'cssplugin'=>$cssplugin
                            ]);
    }

    
}