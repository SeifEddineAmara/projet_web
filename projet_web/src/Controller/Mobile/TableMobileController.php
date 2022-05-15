<?php

namespace App\Controller\Mobile;

use App\Entity\Restaurant;
use App\Entity\Table;
use App\Entity\TableRestaurant;
use App\Repository\TableRestaurantRepository;
use App\Repository\RestaurantRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mobile/table")
 */
class TableMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(TableRestaurantRepository $tableRepository): Response
    {
        $tables = $tableRepository->findAll();

        $tablesJson = [];
        if ($tables) {
            foreach ($tables as $table) {
                $singleTablesJson = $table->jsonSerialize();
                $singleTablesJson["restaurant"] =
                    $this->getDoctrine()->getRepository(Restaurant::class)->find($table->getIdRestaurant());
                $tablesJson[] = $singleTablesJson;
            }
            return new JsonResponse($tablesJson, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, RestaurantRepository $restaurantRepository): JsonResponse
    {
        $table = new TableRestaurant();

        return $this->manage($table, $restaurantRepository, $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, TableRestaurantRepository $tableRepository, RestaurantRepository $restaurantRepository): Response
    {
        $table = $tableRepository->find((int)$request->get("id"));

        if (!$table) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($table, $restaurantRepository, $request, true);
    }

    public function manage($table, $restaurantRepository, $request, $isEdit): JsonResponse
    {
        $restaurant = $restaurantRepository->find((int)$request->get("restaurant"));
        if (!$restaurant) {
            return new JsonResponse("restaurant with id " . (int)$request->get("restaurant") . " does not exist", 203);
        }

        $table->setUp(
            (int)$request->get("type"),
            $restaurant->getId()
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($table);
        $entityManager->flush();

        return new JsonResponse($table, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, TableRestaurantRepository $tableRepository): JsonResponse
    {
        $table = $tableRepository->find((int)$request->get("id"));

        if (!$table) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($table);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, TableRestaurantRepository $tableRepository): Response
    {
        $tables = $tableRepository->findAll();

        foreach ($tables as $table) {
            $entityManager->remove($table);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }

}
