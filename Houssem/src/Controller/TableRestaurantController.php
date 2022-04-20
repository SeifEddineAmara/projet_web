<?php

namespace App\Controller;

use App\Entity\TableRestaurant;
use App\Form\TableRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/table/restaurant")
 */
class TableRestaurantController extends AbstractController
{
    /**
     * @Route("/", name="app_table_restaurant_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tableRestaurants = $entityManager
            ->getRepository(TableRestaurant::class)
            ->findAll();

        return $this->render('table_restaurant/index.html.twig', [
            'table_restaurants' => $tableRestaurants,
        ]);
    }

    /**
     * @Route("/new", name="app_table_restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tableRestaurant = new TableRestaurant();
        $form = $this->createForm(TableRestaurantType::class, $tableRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tableRestaurant);
            $entityManager->flush();

            return $this->redirectToRoute('app_table_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('table_restaurant/new.html.twig', [
            'table_restaurant' => $tableRestaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idTable}", name="app_table_restaurant_show", methods={"GET"})
     */
    public function show(TableRestaurant $tableRestaurant): Response
    {
        return $this->render('table_restaurant/show.html.twig', [
            'table_restaurant' => $tableRestaurant,
        ]);
    }

    /**
     * @Route("/{idTable}/edit", name="app_table_restaurant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TableRestaurant $tableRestaurant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TableRestaurantType::class, $tableRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_table_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('table_restaurant/edit.html.twig', [
            'table_restaurant' => $tableRestaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idTable}", name="app_table_restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, TableRestaurant $tableRestaurant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tableRestaurant->getIdTable(), $request->request->get('_token'))) {
            $entityManager->remove($tableRestaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_table_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
