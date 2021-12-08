<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Admin extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response{
        $this->denyAccessUnlessGranted('ROLE_SUPERADMIN');

        return $this->render('private/admin/index_admin.html.twig');
    }
}
