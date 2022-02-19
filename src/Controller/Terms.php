<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Terms extends AbstractController
{
    /**
     * @Route("/terms-of-service",name="terms")
     */
    public function termsOfService():Response{
        $terms = \file_get_contents(__DIR__ . '/../../terms.html');
        $terms = $terms != false ? $terms : '';

        return $this->render('public/legal.html.twig', [
            'title'=>'Terms of service',
            'content'=>$terms
        ]);
    }
}