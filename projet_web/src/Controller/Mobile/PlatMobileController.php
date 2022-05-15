<?php
namespace App\Controller\Mobile;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use App\Repository\MenuRepository;
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
 * @Route("/mobile/plat")
 */
class PlatMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findAll();

        if ($plats) {
            return new JsonResponse($plats, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, MenuRepository $menuRepository): JsonResponse
    {
        $plat = new Plat();

        return $this->manage($plat, $menuRepository,  $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, PlatRepository $platRepository, MenuRepository $menuRepository): Response
    {
        $plat = $platRepository->find((int)$request->get("id"));

        if (!$plat) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($plat, $menuRepository, $request, true);
    }

    public function manage($plat, $menuRepository, $request, $isEdit): JsonResponse
    {   
        $menu = $menuRepository->find((int)$request->get("menu"));
        if (!$menu) {
            return new JsonResponse("menu with id " . (int)$request->get("menu") . " does not exist", 203);
        }
        
        
        $plat->setUp(
            $menu,
            $request->get("nom"),
            $request->get("element")
        );
        
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($plat);
        $entityManager->flush();

        return new JsonResponse($plat, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, PlatRepository $platRepository): JsonResponse
    {
        $plat = $platRepository->find((int)$request->get("id"));

        if (!$plat) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($plat);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findAll();

        foreach ($plats as $plat) {
            $entityManager->remove($plat);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }
    
}
