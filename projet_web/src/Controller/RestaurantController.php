<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\Restaurant1Type;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/restaurant")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="app_restaurant_index", methods={"GET"})
     */
    public function index(Request $request , EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
    {
        $XX = $entityManager
            ->getRepository(Restaurant::class)
            ->findAll();

        $restaurants= $paginator->paginate(
            $XX,
            $request->query->getInt('page',1),
            2
        ) ;

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
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

        $restaurants= $entityManager
            ->getRepository(Restaurant::class)
            ->findAll();




        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('restaurant/listr.html.twig', [
            'restaurants' => $restaurants,
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


        return $this->render('restaurant/listr.html.twig', [
            'restaurants' => $restaurants,
        ]);

    }


    /**
     * @Route("/new", name="app_restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, \Swift_Mailer $mailer): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(Restaurant1Type::class, $restaurant);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $message= (new \Swift_Message('restaurant bien ajouté'))
                ->setTo('youssef.riahi@esprit.tn')
                ->setFrom('houssem.setti@esprit.tn')
                ->setBody(
                    'bienvenue')
            ;
            $mailer->send($message);

            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_restaurant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Restaurant1Type::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/searchByString/{S}", name="searchByString", methods={"GET"})
     */
    public function searchRestaurantByString(EntityManagerInterface $entityManager,string $S): Response
    {
        $rest = $entityManager
            ->getRepository(Restaurant::class)
            ->findOneBy('nom',$S);

        return $this->render('restaurant/index.html.twig', [
            'rest' => $rest,
        ]);
    }

}
