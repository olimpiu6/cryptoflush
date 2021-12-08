<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\CoinsPrice;
use App\Service\StoreCoinsPrice;


class AdminCoinPrices extends AbstractController{

     /**
     * attributes
     */
    private $sessionData;

    /**
     * constructor, retrieves session information, session id for the token
     */
    public function __construct(){
        $session = new Session();   
        $this->sessionData = $session->getId();
    }

    /**
     * list coin prices
     * @Route("/admin/admin_coin_prices", name="admin_coin_prices")
     */
    public function listCoinPrices(): Response{
        $this->denyAccessUnlessGranted('ROLE_SUPERADMIN');

        //CoinsPrice repository object
        $repository = $this->getDoctrine()->getRepository(CoinsPrice::class);

        //get price list 
        $price_list = $repository->findBy(
                                        array(), 
                                        array('marketCap'=>'DESC'), 
                                        100,
                                        0
                                    );

        return $this->render('private/admin/_coins_price_manager.html.twig', [
                                'price_list'=>$price_list,
                                'user_token' => $this->sessionData
                            ]);
    }

    /**
     * @Route("/update-coin-price", name="update-coin-price")
     */
    public function updateCoinPrice(Request $request): Response{

        if ($request->isXMLHttpRequest()) {      
            //store coin prices object
            $rt = new StoreCoinsPrice($this->getDoctrine()->getManager());

            //try to save rates
            if($rt->storePrices()){
                return new Response('{"done":"done"}', 200);
            }

            return new Response('{"error":"error"}', 200);
        }
    
        return new Response('{"error":"error"}', 200);
    }

}