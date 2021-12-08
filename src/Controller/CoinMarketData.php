<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CoinMarketsData;

class CoinMarketData extends AbstractController{

    /**
     * @Route("/crypto", name="crypto")
     */
    public function showCoinList(): Response{
        //CoinsPrice repository object
        $repository = $this->getDoctrine()->getRepository(CoinMarketsData::class);
        $offset = 0;
        //get price list 
        $market_data = $repository->findLimit($offset, 100);

        return $this->render('public/_market_data.html.twig', [
                                'market_data'=>$market_data
                            ]);
    }

    
}