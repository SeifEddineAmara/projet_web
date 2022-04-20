<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeReservationController extends AbstractController
{
    /**
     * @Route("/home/reservation", name="app_home_reservation")
     */
    public function index(): Response
    {
        return $this->render('home_reservation/index.html.twig', [
            'controller_name' => 'HomeReservationController',
        ]);
    }
}
