<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\CoinMarketsData;

class MainPageController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(): Response{
        //CoinsPrice repository object
        $repository = $this->getDoctrine()->getRepository(CoinMarketsData::class);
        $pag = 1;
        //get price list 
        $market_data = $repository->findLimit(0, 100);

        //create new RssFeed doctrine object, or something like that
        $repository = $this->getDoctrine()->getRepository(Post::class);
        
        //get latest crypto news
        $latestCryptoNews = $repository->findBycategory(1,0,12);

        //js,css plugins for this page
        $jsplugin = array('datatables','chartjs');
        $cssplugin = array('datatables');

        return $this->render('public/index.html.twig', [
                                'cryptonews'=>$latestCryptoNews,
                                'market_data'=>$market_data,
                                'pag'=>$pag,
                                'jsplugin'=>$jsplugin,
                                'cssplugin'=>$cssplugin
                            ]);
    }
}
