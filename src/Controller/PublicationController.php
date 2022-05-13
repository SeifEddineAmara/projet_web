<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\User;
use App\Form\Publication1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{


    /**
     * @Route("/", name="app_publication_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();

        return $this->render('publication/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    /**
     * @Route("/mobile", name="app_mobile_publication_show", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllPubs(SerializerInterface $serializer,EntityManagerInterface $entityManager,NormalizerInterface $normalizer): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();

        $jsoncontent=$normalizer->normalize($publications,'json',['groups'=>'post:read']);
        return new JsonResponse($jsoncontent);
    }



    public function getUserByID(int $x) :?User
    {
        $user = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findOneBy(['id'=>$x]);
        return $user;
    }

    /**
     * @Route("/new", name="app_publication_new", methods={"GET", "POST"})
     */

    public function new (Request $request): Response
    {
        $publication = new Publication();
        $form = $this->createForm(Publication1Type::class, $publication);
        $libellePublication = $request->query->get("lib");
        $nbReaction = $request->query->get("nbreact");
        $idUser=$request->query->get("iduser");


        $publication->setLibellePublication($libellePublication);
        $publication->setNbReaction($nbReaction);
        $publication->setIdUser($this->getUserByID($idUser));


        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($publication);
        $entityManager->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        return new JsonResponse("added");

    }



    /**
     * @Route("/newPub1", name="app_publication_newpub", methods={"GET", "POST"})
     * @return JsonResponse
     */

    public function newPub1(Request $request, NormalizerInterface $normalizer ): JsonResponse
    {
        $userNew=$this->getUserByID(123456695);
        $em = $this->getDoctrine()->getManager();
        $pub = new Publication();
        $pub->setLibellePublication($request->get('lib'));
        $pub->setNbReaction((int)$request->get('nbreact'));
        $pub->setIdUser($userNew);
        $em->persist($pub);
        $em->flush();
        return new JsonResponse("Done");
    }


   






//    public function new(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $publication = new Publication();
//        $form = $this->createForm(Publication1Type::class, $publication);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($publication);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->render('publication/new.html.twig', [
//            'publication' => $publication,
//            'form' => $form->createView(),
//        ]);
//    }



    /**
     * @Route("/{idPublication}", name="app_publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/{idPublication}/edit", name="app_publication_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Publication1Type::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{idPublication}", name="app_publication_delete", methods={"POST"})
     */
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getIdPublication(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }


}
