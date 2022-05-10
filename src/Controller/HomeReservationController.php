<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/home/reservation/reserver", name="app_home_reservation_reserver")
     */
    public function show(): Response
    {
        return $this->render('home_reservation/reserver.html.twig', [
            'controller_name' => 'HomeReservationController',
        ]);
    }

    /**
     * @Route("/home/reservation/reserver", name="app_home_reservation_reserver")
     */
    public function new(Request $request, EntityManagerInterface $entityManager ,\Swift_Mailer $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message= (new \Swift_Message('TAP&GO'))
                ->setTo('houssemsetties@gmail.com')
                ->setFrom('taabaniesprit@gmail.com')
                ->setBody(
                    'Votre Reservation est confirmé! Merci pour nous faire confiance.'
                )
            ;
            $mailer->send($message);

            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_home_reservation_reserver', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home_reservation/reserver.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/home/reservation/reserver/data", name="app_home_reservation_reserver_data")
     */
    public function Res(): Response
    {
        return $this->render('home_reservation/data.html.twig', [
            'controller_name' => 'HomeReservationController',
        ]);
    }

}
