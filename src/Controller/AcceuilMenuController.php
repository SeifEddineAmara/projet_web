<?php

namespace App\Controller;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilMenuController extends AbstractController
{
    /**
     * @Route("/acceuil/menu", name="app_acceuil_menu")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $menus = $entityManager
            ->getRepository(Menu::class)
            ->findAll();

        return $this->render('acceuil_menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }



    /**
     * @Route("/acceuil/menu/{idRestaurant}", name="acceuil_menuByIdRestaurantFT")
     */
    public function menuByIdRestaurant(int $idRestaurant , EntityManagerInterface $entityManager ): Response
    {
        $menus = $entityManager
            ->getRepository(Menu::class)
            ->findBy(['restaurant'=>$idRestaurant]);
        return $this->render('acceuil_menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }



    
}
