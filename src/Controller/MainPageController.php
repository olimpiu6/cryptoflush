<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\CoinsPrice;

class MainPageController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(): Response{
        //create new RssFeed doctrine object, or something like that
        $repository = $this->getDoctrine()->getRepository(Post::class);
        
        //get latest crypto news
        $latestCryptoNews = $repository->findBycategory(1, 0, 6);

        //get coins price data

        return $this->render('public/index.html.twig', [
                                'cryptonews'=>$latestCryptoNews
                            ]);
    }
}
