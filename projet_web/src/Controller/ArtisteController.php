<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Form\SearchArtisteType;
use App\Repository\ArtisteRepository;
use App\Repository\EvenementRepository;
use App\Search\ArtisteSearchData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/artiste")
 */
class ArtisteController extends AbstractController
{
    /**
     * @Route("/", name="app_artiste_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager,
                          ArtisteRepository $repository): Response
    {
        $data = new ArtisteSearchData();
        $form = $this->createForm(SearchArtisteType::class, $data);
        $form->handleRequest($request);

        $artistes = $repository->findSearch($data);

        return $this->render('artiste/index.html.twig', [
            'form' => $form->createView(),
            'artistes' => $artistes,
        ]);
    }

    /**
     * @Route ("/liste", name="app_artiste_liste", methods={"GET"})
     */
    public function getEvenements(ArtisteRepository $repository, SerializerInterface $serializer): Response{
        $artistes = $repository->findAll();
        $json = $serializer->serialize($artistes, 'json');
        return new jsonResponse($json,'200',[], true);
    }

    /**
     * @Route("/new", name="app_artiste_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artiste = new Artiste();
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artiste);
            $entityManager->flush();

            return $this->redirectToRoute('app_artiste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artiste/new.html.twig', [
            'artiste' => $artiste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idArtiste}", name="app_artiste_show", methods={"GET"})
     */
    public function show(Artiste $artiste): Response
    {
        return $this->render('artiste/show.html.twig', [
            'artiste' => $artiste,
        ]);
    }

    /**
     * @Route("/{idArtiste}/edit", name="app_artiste_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Artiste $artiste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_artiste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artiste/edit.html.twig', [
            'artiste' => $artiste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idArtiste}", name="app_artiste_delete", methods={"POST"})
     */
    public function delete(Request $request, Artiste $artiste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artiste->getIdArtiste(), $request->request->get('_token'))) {
            $entityManager->remove($artiste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_artiste_index', [], Response::HTTP_SEE_OTHER);
    }
}
