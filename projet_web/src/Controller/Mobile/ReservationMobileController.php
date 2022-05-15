<?php

namespace App\Controller\Mobile;

use App\Entity\Reservation;
use App\Entity\Restaurant;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TableRestaurantRepository;
use App\Repository\UserRepository;
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
 * @Route("/mobile/reservation")
 */
class ReservationMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        $reservationsJson = [];
        if ($reservations) {
            foreach ($reservations as $reservation) {
                $singleReservationsJson = $reservation->jsonSerialize();
                $singleReservationsJson["restaurant"] = $this->getDoctrine()->getRepository(Restaurant::class)->find($reservation->getIdRestaurant());
                $reservationsJson[] = $singleReservationsJson;
            }
            return new JsonResponse($reservationsJson, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, RestaurantRepository $restaurantRepository, TableRestaurantRepository $tableRepository, UserRepository $userRepository): JsonResponse
    {
        $reservation = new Reservation();

        return $this->manage($reservation, $restaurantRepository, $tableRepository, $userRepository, $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, ReservationRepository $reservationRepository, RestaurantRepository $restaurantRepository, TableRestaurantRepository $tableRepository, UserRepository $userRepository): Response
    {
        $reservation = $reservationRepository->find((int)$request->get("id"));

        if (!$reservation) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($reservation, $restaurantRepository, $tableRepository, $userRepository, $request, true);
    }

    public function manage($reservation, $restaurantRepository, $tableRepository, $userRepository, $request, $isEdit): JsonResponse
    {
        $restaurant = $restaurantRepository->find((int)$request->get("restaurant"));
        if (!$restaurant) {
            return new JsonResponse("restaurant with id " . (int)$request->get("restaurant") . " does not exist", 203);
        }

        $table = $tableRepository->find((int)$request->get("table"));

        if (!$table) {
            return new JsonResponse("table with id " . (int)$request->get("table") . " does not exist", 203);
        }

        $user = $userRepository->find((int)$request->get("user"));
        if (!$user) {
            return new JsonResponse("user with id " . (int)$request->get("user") . " does not exist", 203);
        }


        $reservation->setUp(
            (int)$request->get("heure"),
            $request->get("date"),
            $restaurant->getId(),
            $table,
            $user
        );


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reservation);
        $entityManager->flush();

        return new JsonResponse($reservation, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): JsonResponse
    {
        $reservation = $reservationRepository->find((int)$request->get("id"));

        if (!$reservation) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($reservation);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        foreach ($reservations as $reservation) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }

}
