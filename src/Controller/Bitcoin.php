<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BtcExchangeRates;

class Bitcoin extends AbstractController{

    /**
     * @Route("/bitcoin-exchange-rates", name="bitcoin-exchange-rates")
     */
    public function exchangeRates(): Response{
        try{
            //create new BtcExchangeRates doctrine object, or something like that
            $repository = $this->getDoctrine()->getRepository(BtcExchangeRates::class);

            //get rates list, thats all the data from btc_exchange_rates table
            $rates = $repository->findAll();
           
        }catch(\Exception $e){
            //echo $e->getMessage();
            return $this->render('public/_404.html.twig');
        }

        return $this->render('public/_btc_rates.html.twig', [
                                'rates'=>$rates
                            ]);
    }
}