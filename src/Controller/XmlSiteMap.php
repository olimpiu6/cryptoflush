<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\CoinMarketsData;

class XmlSiteMap extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function googleSiteMap(Request $request ): Response{

        $hostname = $request->getSchemeAndHttpHost() . '/';

        //get post repository
        //list first x amount of coins
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $url_list = $repository->getAllPostsUrl();

        return $this->render('sitemap.html.twig', [
                'url_list'=>$url_list,
                'hostname'=>$hostname
        ]);
    }

    /**
     * @Route("/sitemap-coins.xml", name="sitemapcoins", defaults={"_format"="xml"})
     */
    public function googleSiteMapCoins(Request $request ): Response{

        $hostname = $request->getSchemeAndHttpHost() . '/';

        //get post repository
        //list first x amount of coins
        $repository = $this->getDoctrine()->getRepository(CoinMarketsData::class);
        $url_list = $repository->findAllTickers();

        return $this->render('sitemap-coins.html.twig', [
                'url_list'=>$url_list,
                'hostname'=>$hostname
        ]);
    }
}