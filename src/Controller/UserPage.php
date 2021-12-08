<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPage extends AbstractController
{
    /**
     * @Route("/user_page", name="user_page")
     */
    public function index(): Response{

        return $this->render('private/user/index_user.html.twig');
    }
}