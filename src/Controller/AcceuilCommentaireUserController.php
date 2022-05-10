<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\User;
use App\Form\Commentaire1Type;
use App\Form\Commentaire2Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilCommentaireUserController extends AbstractController
{
    /**
     * @Route("/acceuil/commentaire/user", name="app_acceuil_commentaire_user")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('acceuil_commentaire_user/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    public function getUserByID(int $x) :?User
    {
        $useridLastTry = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findOneBy(['id'=>$x]);
        return $useridLastTry;
    }

    public function getThePublicationById(int $a) :?Publication
    {
        $publicationLastTry=$this->getDoctrine()->getManager()
            ->getRepository(Publication::class)
            ->findOneBy(['idPublication'=>$a]);
        return publicationLastTry;

    }

    function filterwords($text){
        $delimiter = ',';
        $enclosure = '"';
        $header = NULL;
        $data = array();

        if (($handle = fopen("https://docs.google.com/spreadsheets/d/10P3ihV-l2Hz9Jm1Cprp8S7mTKqYsOZWxzaNOC8ij72M/export?format=csv", 'r')) !== FALSE) {

            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) {

                if(!$header) {
                    $header = $row;

                } else {
                    array_push($data,$row);
                }
            }
            fclose($handle);
        }
        #dd($data[300][0]);
        $filterWords = array('badword');
        foreach($data as $s)
        {
            array_push($filterWords,$s[0]);
        }

        #dd($filterWords);
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }


    /**
     * @Route("/acceuil/commentaire/user/{idPublication}/{idUser}", name="acceuil_commentaireByIdPublication")
     */
    public function commentaireByIdPublication(int $idPublication , int $idUser , EntityManagerInterface $entityManager , Request $request): Response
    {

        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findBy(['idPublication' => $idPublication]);
        $commentaire = new Commentaire();
        $publicationLastTry=$this->getDoctrine()->getManager()
            ->getRepository(Publication::class)
            ->findOneBy(['idPublication'=>$idPublication]);
        $commentaire->setIdPublication($publicationLastTry);
        $useridLastTry = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findOneBy(['id'=>$idUser]);
        $commentaire->setIdUser($useridLastTry);
        $form = $this->createForm(Commentaire2Type::class, $commentaire);
        $form->handleRequest($request);
        $badWords = $this->filterwords($commentaire->getLibelleCommentaire() . ' ' . $commentaire->getLibelleCommentaire());
        if (strpos($badWords, '**') !== false) {
            $this->addFlash('info', 'Faites attention a ce que vous tapez  ! un peu de respect !!');

        } else {

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($commentaire);
                $entityManager->flush();

            }
        }
        return $this->render('acceuil_commentaire_user/index.html.twig', [
            'commentaires' => $commentaires,
            'form' => $form->createView(),
        ]);

    }
}
