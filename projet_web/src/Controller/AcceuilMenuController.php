<?php

namespace App\Controller;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/acceuil/menu/{id_restaurant}", name="acceuil_menuByIdRestaurant")
     */
    public function menuByIdRestaurant(EntityManagerInterface $entityManager , int $id_restaurant): Response
    {
        $menusId = $entityManager
            ->getRepository(Menu::class)
            ->findBy(['restaurant'=>$id_restaurant]);

        return $this->render('acceuil_menu/index.html.twig', [
            'menus' => $menusId,
        ]);
    }
    
    
}
