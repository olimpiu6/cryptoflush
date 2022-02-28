<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CoinDailyChart;
use App\Entity\CoinMarketsData;
use App\Entity\CoinInfo;

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
        $chart_data = $this->getDoctrine()->getRepository(CoinDailyChart::class)->findOneBy(['coinTicker'=>$ticker]);

        //coin market repository
        $market_data = $this->getDoctrine()->getRepository(CoinMarketsData::class)->findOneBy(['coinTicker'=>$ticker]);

        //coin info
        $coin_info = $this->getDoctrine()->getRepository(CoinInfo::class)->findOneBy(['ticker'=>$ticker]);

        //js plugins
        $jsplugin = array('marketdata','trviewchart');

        return $this->render('public/coin_info.html.twig', [
                                'chart_data'=>$chart_data,
                                'market_data'=>$market_data,
                                'coin_info' => $coin_info,
                                'jsplugin' =>$jsplugin
                            ]);
    }

    
}