<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CoinsPrice;

class Coin extends AbstractController{

    /**
     * @Route("/coins", name="coins")
     */
    public function showCoinList(): Response{
        //CoinsPrice repository object
        $repository = $this->getDoctrine()->getRepository(CoinsPrice::class);

        //get price list 
        $price_list = $repository->findBy(
                                        array(), 
                                        array('marketCap'=>'DESC'), 
                                        100,
                                        0
                                    );

        return $this->render('public/_coin_list.html.twig', [
                                'price_list'=>$price_list
                            ]);
    }

    
}