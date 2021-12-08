<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\RssFeedType;
use App\Entity\RssFeed;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminRssManager extends AbstractController
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
     * @Route("/admin/admin_rss_manager", name="admin_rss_manager")
     */
    public function rssFeed(Request $request): Response{
        $this->denyAccessUnlessGranted('ROLE_SUPERADMIN');
        //rss object
        $rss = new RssFeed();

        //form object
        $form = $this->createForm(RssFeedType::class, $rss);

        //validate form data
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$rss` variable has also been updated
            $rss = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rss);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('admin_rss_manager');
        }

        //list all rss feeds stored in the db
        $repository = $this->getDoctrine()->getRepository(RssFeed::class);
        $feedList = $repository->findAll();

        return $this->render('private/admin/_rss_manager.html.twig', [
            'form' => $form->createView(),
            'feed_list' => $feedList,
            'user_token' => $this->sessionData
        ]);
    }
}
