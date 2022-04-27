<?php

namespace App\Controller;

use App\Entity\Chefs;
use App\Form\ChefsType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PropertySearchType;
use App\Entity\PropertySearch;

/**
 * @Route("/chefs")
 */
class ChefsController extends AbstractController
{
    /**
     * @Route("/", name="app_chefs_index")
     * @param Request $request
     * @param $nomChef
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);

        $chefs = [];

        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $nom = $propertySearch->getNom();
            if ($nom!="")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
               $chefs= $this->getDoctrine()->getRepository(Chefs::class)->findBy(['nomChef' => $nom] );
            else
                //si si aucun nom n'est fourni on affiche tous les articles
                $chefs= $this->getDoctrine()->getRepository(Chefs::class)->findAll();
        }

        //$donnes = $entityManager
          //  ->getRepository(Chefs::class)
            //->findAll();
        //$chef = $paginator->paginate(
          //  $donnes,
           // $request->query->getInt('page',1),2
        //) ;
        return $this->render('chefs/index.html.twig', ['form' =>$form->createView(),
            'chefs'=>$chefs,
        ]);

    }
    

    /**
     * @Route("/new", name="app_chefs_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chef = new Chefs();
        $form = $this->createForm(ChefsType::class, $chef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chef);
            $entityManager->flush();

            return $this->redirectToRoute('app_chefs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chefs/new.html.twig', [
            'chef' => $chef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idChef}", name="app_chefs_show", methods={"GET"})
     */
    public function show(Chefs $chef): Response
    {
        return $this->render('chefs/show.html.twig', [
            'chef' => $chef,
        ]);
    }

    /**
     * @Route("/{idChef}/edit", name="app_chefs_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Chefs $chef, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChefsType::class, $chef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chefs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chefs/edit.html.twig', [
            'chef' => $chef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idChef}", name="app_chefs_delete", methods={"POST"})
     */

    public function delete(Request $request, Chefs $chef, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chef->getIdChef(), $request->request->get('_token'))) {
            $entityManager->remove($chef);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chefs_index', [], Response::HTTP_SEE_OTHER);
    }
}
