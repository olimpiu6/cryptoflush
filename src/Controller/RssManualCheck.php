<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StoreRssData;
use App\Entity\RssFeed;

class RssManualCheck extends AbstractController
{
    /**
     * @Route("/rss-manual-check", name="rss-manual-check")
     */
    public function rssManualCheck(Request $request): Response{

        if ($request->isXMLHttpRequest()) {      
            //create new RssFeed doctrine object, or something like that
            $repository = $this->getDoctrine()->getRepository(RssFeed::class);

            //search for active feeds in the db
            $feeds = $repository->findBy(['active'=>1]);

            //loop throught all objcts
            if(\is_array($feeds)){
                foreach($feeds as $key=>$val){
                    $rss = new StoreRssData($val->getUrl(), 
                                            $this->getDoctrine()->getManager());
                    $rss->rssToDatabase();

                    //wait one sec
                    \sleep(1);
                }
            }
            //var_dump($feeds);

            return new Response('{"done":"done"}', 200);
        }
    
        return new Response('{"error":"error"}', 200);
    }
}