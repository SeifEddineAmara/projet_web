<?php

namespace App\Controller;

use App\Entity\TypeDeMusique;
use App\Form\SearchTypeDeMusiqueType;
use App\Form\TypeDeMusiqueType;
use App\Repository\EvenementRepository;
use App\Repository\TypeDeMusiqueRepository;
use App\Search\TypeDeMusiqueSearchData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/type/de/musique")
 */
class TypeDeMusiqueController extends AbstractController
{
    /**
     * @Route("/", name="app_type_de_musique_index", methods={"GET", "POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager,
                          TypeDeMusiqueRepository $repository): Response
    {
        $data = new TypeDeMusiqueSearchData();
        $form = $this->createForm(SearchTypeDeMusiqueType::class, $data);
        $form->handleRequest($request);

        $typesDeMusique = $repository->findSearch($data);

        return $this->render('type_de_musique/index.html.twig', [
            'form' => $form->createView(),
            'typesDeMusique' => $typesDeMusique,
        ]);
    }

    /**
     * @Route("/new", name="app_type_de_musique_new", methods={"GET"})
     */
    public function new(Request $request, TypeDeMusiqueRepository $typeDeMusiqueRepository): Response
    {
        $typeDeMusique = new TypeDeMusique();
        $form = $this->createForm(TypeDeMusiqueType::class, $typeDeMusique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $typeDeMusiqueRepository->add($typeDeMusique);
            } catch (OptimisticLockException|ORMException $e) {
            }
            return $this->redirectToRoute('app_type_de_musique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_de_musique/new.html.twig', [
            'type_de_musique' => $typeDeMusique,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route ("/liste", name="app_evenement_liste")
     */
    public function getEvenements(TypeDeMusiqueRepository $repository, SerializerInterface $serializer): Response{
        $typeDeMusique = $repository->findAll();
        $json = $serializer->serialize($typeDeMusique, 'json');
        return new jsonResponse($json,'200',[], true);
    }

    /**
     * @Route("/{id}", name="app_type_de_musique_show", methods={"GET"})
     */
    public function show(TypeDeMusique $typeDeMusique): Response
    {
        return $this->render('type_de_musique/show.html.twig', [
            'type_de_musique' => $typeDeMusique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_de_musique_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeDeMusique $typeDeMusique, TypeDeMusiqueRepository $typeDeMusiqueRepository): Response
    {
        $form = $this->createForm(TypeDeMusiqueType::class, $typeDeMusique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $typeDeMusiqueRepository->add($typeDeMusique);
            } catch (OptimisticLockException|ORMException $e) {
            }
            return $this->redirectToRoute('app_type_de_musique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_de_musique/edit.html.twig', [
            'type_de_musique' => $typeDeMusique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_de_musique_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeDeMusique $typeDeMusique, TypeDeMusiqueRepository $typeDeMusiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeDeMusique->getId(), $request->request->get('_token'))) {
            try {
                $typeDeMusiqueRepository->remove($typeDeMusique);
            } catch (OptimisticLockException|ORMException $e) {
            }
        }

        return $this->redirectToRoute('app_type_de_musique_index', [], Response::HTTP_SEE_OTHER);
    }
}
