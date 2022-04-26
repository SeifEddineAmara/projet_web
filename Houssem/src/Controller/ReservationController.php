<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\ReservationRepositoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;


/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="app_reservation_index", methods={"GET"})
     */
    public function index(Request $request , EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
    {
        $XX = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        $reservations = $paginator->paginate(
            $XX,
            $request->query->getInt('page',1),
            4
        ) ;

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }



    /**
     * @Route("/listr", name="app_reservation_listr", methods={"GET"})
     */
    public function listr(EntityManagerInterface $entityManager): Response
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $reservations= $entityManager
            ->getRepository(Reservation::class)
            ->findAll();




        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservation/listr.html.twig', [
            'reservations' => $reservations,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);


return $this->render('reservation/listr.html.twig', [
'reservations' => $reservations,
]);

    }


        /**
     * @Route("/new", name="app_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReservation}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{idReservation}/edit", name="app_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReservation}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/stat/gen",name="app_reservation_stat")
     */

    public function statistiques(ReservationRepository $reservationRepository): Response
    {
        //    $p=$this->getDoctrine()->getRepository(User::class);
        $nbs = $reservationRepository->getNb();
        $data = [['idUser', 'Nombre ']];

        foreach($nbs as $nb)
        {
            $data[] = array(
                $nb['usr'], $nb['loo'])
            ;
        }
        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable(
            $data
        );
        $bar->getOptions()->setTitle('Meilleur client');
        $bar->getOptions()->getTitleTextStyle()->setColor('#2f323a');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);
        return $this->render('reservation/Stat.html.twig',
            array('chart' => $bar,'nbs' => $nbs));

    }


}
