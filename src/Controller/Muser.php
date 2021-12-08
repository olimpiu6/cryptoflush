<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Category;

class Muser extends AbstractController
{
    /**
     * @Route("/myuser", name="myuser")
     */
    public function index(UserPasswordEncoderInterface $encoder): Response{
        $u = new User();
        $u->setEmail('olimpiu6@gmail.com');
        
        $u->setRoles(array('ROLE_SUPERADMIN'));

        
        $plainPassword = 'Madriz@2015';
        $encoded = $encoder->encodePassword($u, $plainPassword);
        $u->setPassword($encoded);

        $em = $this->getDoctrine()->getManager();
        $em->persist($u);
        $em->flush();

        var_dump($u);

        return $this->render('public/index.html.twig');
    }

    /**
     * @Route("/mycat", name="mycat")
     */
    public function catMaker(): Response{
        $u = new Category();
        $u->setName('Crypto News');
        $u->setUrl('crypto-news');
        $u->setLang('en');
        $u->setActive(1);

        

        $em = $this->getDoctrine()->getManager();
        $em->persist($u);
        $em->flush();

        var_dump($u);

        return $this->render('public/index.html.twig');
    }
}
