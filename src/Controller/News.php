<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class News extends AbstractController
{
    /**
     * @Route("/news/{url}", name="news")
     */
    public function index($url): Response{

        try{
            //create new RssFeed doctrine object, or something like that
            $repository = $this->getDoctrine()->getRepository(Post::class);

            //get full post by url
            $news = $repository->findBy(['utl'=>$url]);
           
            //more_cryptonews
            $more_cryptonews = $repository->findMoreNew(0, 6, $news[0]->getUtl());
        }catch(\Exception $e){
            //echo $e->getMessage();
            return $this->render('public/_404.html.twig');
        }

        return $this->render('public/_news.html.twig', [
                                'news'=>$news,
                                'more_cryptonews'=>$more_cryptonews
                            ]);
    }
}
