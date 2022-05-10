<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Reponse;
use App\Entity\User;
use App\Form\Publication1Type;
use App\Form\Publication2Type;
use Doctrine\ORM\EntityManagerInterface;
use Snipe\BanBuilder\CensorWords;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserInterfaceController extends AbstractController
{
    /**
     * @Route("/user", name="app_user_interface")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();

        return $this->render('user_interface/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    /**
     * @Route("/new", name="app_user_interface_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publication = new Publication();
        $form = $this->createForm(Publication2Type::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_interface', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_interface/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    public function getUserByID(int $x) :?User
    {
        $user = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findOneBy(['id'=>$x]);
        return $user;
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
     * @Route("/savePub/{idUser}", name="savePub", methods={"GET", "POST"})
     */
    public function savePub(Request $request, EntityManagerInterface $entityManager, int $idUser): Response
    {

        $publication = new Publication();
        $publication->setNbReaction(0);
        //   $u

        $publication->setIdUser($this->getUserByID($idUser));
        $form = $this->createForm(Publication2Type::class, $publication);
        $form->handleRequest($request);
        $badWords = $this->filterwords($publication->getLibellePublication() . ' ' . $publication->getLibellePublication());
        if (strpos($badWords, '**') !== false) {
            $this->addFlash('info', 'Faites attention a ce que vous tapez  ! un peu de respect !!');


        } else {

            if ($form->isSubmitted() && $form->isValid()) {
                $libelle_form = $form->getData()->getLibellePublication();

                $entityManager->persist($publication);
                $entityManager->flush();

                return $this->redirectToRoute('app_user_interface', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->render('user_interface/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }
}

