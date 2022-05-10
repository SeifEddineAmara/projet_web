<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\User;
use App\Form\Commentaire1Type;
use App\Form\Publication1Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;



use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="app_commentaire_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * @Route("/allComms", name="app_mobile_commentaire_index", methods={"GET"})
     */
    public function getAllCom(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $comms = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();
        $json = $serializer->serialize($comms, 'json', ['groups' => 'commentaire:read']);
        return new JsonResponse($json, 200, [], true);
    }



    public function getUserByID(int $a) :?User
    {
        $user = $this->getDoctrine()->getManager()

            ->getRepository(User::class)
            ->findOneBy(['id'=>$a]);
        return $user;
    }


    public function getPubByID(int $x): ?Publication
    {
        $pub = $this->getDoctrine()->getManager()
            ->getRepository(Publication::class)
            ->findOneBy(['idPublication' => $x]);
        return $pub;
    }

    /**
     * @Route("/neww", name="app_comm_new", methods={"GET", "POST"})
     */
    public function new (Request $request): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $libelleCommentaire = $request->query->get("libelleCom");
        $idUser = $request->query->get("iduser");
        $idPublication = $request->query->get("idpub");


        $commentaire->setLibelleCommentaire($libelleCommentaire);
        $commentaire->setIdUser($this->getUserByID($idUser));
        $commentaire->setIdPublication($this->getPubByID($idPublication));

        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commentaire);
        $entityManager->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        return new JsonResponse("added");

    }
    /**
     * @Route("/new", name="app_commentaire_new", methods={"GET", "POST"})
     */
    public function newback(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }





    /**
     * @Route("/{idCommentaire}", name="app_commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{idCommentaire}/edit", name="app_commentaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCommentaire}", name="app_commentaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getIdCommentaire(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }



}
