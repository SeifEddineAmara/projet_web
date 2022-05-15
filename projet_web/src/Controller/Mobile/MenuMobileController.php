<?php
namespace App\Controller\Mobile;

use App\Entity\Menu;
use App\Repository\MenuRepository;
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
 * @Route("/mobile/menu")
 */
class MenuMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findAll();

        if ($menus) {
            return new JsonResponse($menus, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, RestaurantRepository $restaurantRepository): JsonResponse
    {
        $menu = new Menu();

        return $this->manage($menu, $restaurantRepository,  $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, MenuRepository $menuRepository, RestaurantRepository $restaurantRepository): Response
    {
        $menu = $menuRepository->find((int)$request->get("id"));

        if (!$menu) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($menu, $restaurantRepository, $request, true);
    }

    public function manage($menu, $restaurantRepository, $request, $isEdit): JsonResponse
    {   
        $restaurant = $restaurantRepository->find((int)$request->get("restaurant"));
        if (!$restaurant) {
            return new JsonResponse("restaurant with id " . (int)$request->get("restaurant") . " does not exist", 203);
        }
        
        
        $menu->setUp(
            $restaurant,
            $request->get("nom"),
            $request->get("type")
        );
        
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($menu);
        $entityManager->flush();

        return new JsonResponse($menu, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, MenuRepository $menuRepository): JsonResponse
    {
        $menu = $menuRepository->find((int)$request->get("id"));

        if (!$menu) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($menu);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findAll();

        foreach ($menus as $menu) {
            $entityManager->remove($menu);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }
    
}
