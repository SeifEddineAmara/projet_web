<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChikaController extends AbstractController
{
    /**
     * @Route("/chika", name="app_chika")
     */
    public function index(): Response
    {
        return $this->render('chika/index.html.twig', [
            'controller_name' => 'ChikaController',
        ]);
    }


    /**
     * @Route("/chika7777/{name}", name="chika7777")
     */
    public function ChikaShow(String $name): Response
    {
        return $this->render('chika/index.html.twig', [
            'name'=>$name
        ]);
    }
}
