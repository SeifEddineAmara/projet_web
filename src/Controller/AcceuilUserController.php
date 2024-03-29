<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilUserController extends AbstractController
{
    /**
     * @Route("/userR", name="app_acceuil_user")
     */
    public function index(): Response
    {
        return $this->render('acceuil_user/index.html.twig', [
            'controller_name' => 'AcceuilUserController',
        ]);
    }
}
