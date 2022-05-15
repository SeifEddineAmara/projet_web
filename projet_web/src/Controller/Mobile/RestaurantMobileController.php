<?php
namespace App\Controller\Mobile;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
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
 * @Route("/mobile/restaurant")
 */
class RestaurantMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        $restaurants = $restaurantRepository->findAll();

        if ($restaurants) {
            return new JsonResponse($restaurants, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, UserRepository $userRepository): JsonResponse
    {
        $restaurant = new Restaurant();

        return $this->manage($restaurant, $userRepository,  $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, RestaurantRepository $restaurantRepository, UserRepository $userRepository): Response
    {
        $restaurant = $restaurantRepository->find((int)$request->get("id"));

        if (!$restaurant) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($restaurant, $userRepository, $request, true);
    }

    public function manage($restaurant, $userRepository, $request, $isEdit): JsonResponse
    {   
        $user = $userRepository->find((int)$request->get("user"));
        if (!$user) {
            return new JsonResponse("user with id " . (int)$request->get("user") . " does not exist", 203);
        }
        
        
        $restaurant->setUp(
            $user,
            $request->get("nom"),
            $request->get("adresse"),
            $request->get("domaine"),
            (int)$request->get("nb")
        );
        
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($restaurant);
        $entityManager->flush();

        return new JsonResponse($restaurant, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, RestaurantRepository $restaurantRepository): JsonResponse
    {
        $restaurant = $restaurantRepository->find((int)$request->get("id"));

        if (!$restaurant) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($restaurant);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, RestaurantRepository $restaurantRepository): Response
    {
        $restaurants = $restaurantRepository->findAll();

        foreach ($restaurants as $restaurant) {
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }
    
}
