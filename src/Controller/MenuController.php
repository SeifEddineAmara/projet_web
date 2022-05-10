<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\Menu1Type;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;

/**
 * @Route("/menu")
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/", name="app_menu_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $menus = $entityManager
            ->getRepository(Menu::class)
            ->findAll();

        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }

    /**
     * @Route("/new", name="app_menu_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $form = $this->createForm(Menu1Type::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($menu);
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_menu_show", methods={"GET"})
     */
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_menu_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Menu1Type::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_menu_delete", methods={"POST"})
     */
    public function delete(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($menu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/stat/gen",name="app_restaurant_stat")
     */
    public function stat(MenuRepository $menuRepository): Response
    {
        //    $p=$this->getDoctrine()->getRepository(User::class);
        $nbs = $menuRepository->getNb();
        $data = [['Type', 'Nombre ']];

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
        $bar->getOptions()->setTitle('type menu');
        $bar->getOptions()->getTitleTextStyle()->setColor('#2f323a');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);
        return $this->render('menu/Stat.html.twig',
            array('chart' => $bar,'nbs' => $nbs));

    }


}
