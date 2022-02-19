<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CoinDailyChart;
use App\Entity\CoinMarketsData;

class Coin extends AbstractController{

    /**
     * @Route("/coins/{ticker}", name="coins")
     */
    public function showCoinInfo($ticker = NULL): Response{
        //redirect to market data if no ticker
        if($ticker == NULL){
           return $this->redirectToRoute('crypto');
        }
        //CoinDailyChart repository object
        $chartrepo = $this->getDoctrine()->getRepository(CoinDailyChart::class);

        //coin market repository
        $marketrepo = $this->getDoctrine()->getRepository(CoinMarketsData::class);

        //get market repo data
        $market_data = $marketrepo->findBy(['coinTicker'=>$ticker]);

        //get chart data
        $chart_data = $chartrepo->findBy(['coinTicker'=>$ticker]);

        return $this->render('public/coin_info.html.twig', [
                                'chart_data'=>$chart_data,
                                'market_data'=>$market_data,
                            ]);
    }

    
}