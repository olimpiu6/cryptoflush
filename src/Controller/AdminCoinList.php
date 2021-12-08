<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Coins;
use App\Service\StoreCoinsData;

class AdminCoinList extends AbstractController
{   
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
     * @Route("/admin/admin_coin_list", name="admin_coin_list")
     */
    public function rssFeed(Request $request): Response{
        $this->denyAccessUnlessGranted('ROLE_SUPERADMIN');
        
        //list first x amount of coins
        $repository = $this->getDoctrine()->getRepository(Coins::class);
        $coinList = $repository->findLimit(100, 0);

        return $this->render('private/admin/_coins_manager.html.twig', [
            'coin_list' => $coinList,
            'user_token'=>$this->sessionData
        ]);
    }

    /**
     *  @Route("coin-manual-check", name="coin-manual-check")
     */
    public function CoinListManualCheck(Request $request): Response{
        if ($request->isXMLHttpRequest()) {      
            //save rates object
            $rt = new StoreCoinsData($this->getDoctrine()->getManager());

            //try to save rates
            if($rt->saveCoinsData()){
                return new Response('{"done":"done"}', 200);
            }

            return new Response('{"error":"error"}', 200);
        }
    
        return new Response('{"error":"error"}', 200);
    }
}