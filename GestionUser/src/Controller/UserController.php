<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RecuperermotdepasseType;
use App\Form\RegisterType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(Request $request , EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
    {
        $XX = $entityManager
            ->getRepository(User::class)
            ->findAll();
        $users = $paginator->paginate(
            $XX,
            $request->query->getInt('page',1),
            6
        ) ;
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    /**
     * @Route("/profile", name="app_user_profile", methods={"GET"})
     */
    public function profile(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/profile.html.twig', [

        ]);
    }

    /**
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user, $form->get('password')->getData()
                )
            );
            $user->setRoles(["ROLE_OWNER"]);
            $user->setAcces("oui");

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/register", name="app_user_register", methods={"GET", "POST"})
     */
    public function register(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAcces("oui");
            $user->setRoles(["ROLE_CLIENT"]);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user, $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_user_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/register.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user, $form->get('password')->getData()
                )
            );
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editprofile", name="app_user_editprofile", methods={"GET", "POST"})
     */
    public function editprofile(Request $request, User $user, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user, $form->get('password')->getData()
                )
            );
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editprofile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/rec/a", name="user_rec", methods={"GET", "POST"})
     * @throws \Exception
     */
    public function RECC(Request $request, EntityManagerInterface $entityManager,\Swift_Mailer $mailer,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RecuperermotdepasseType::class, $user);
        $form->handleRequest($request);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $newPass = substr(str_shuffle($chars),0,10) ;

        if ( $form->isSubmitted() ) {

            $email = $user->getEmail() ;


            $XX = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$email]) ;
            if(is_null($XX)){
                return $this->redirectToRoute('app_user_register');
            }else{
                $XX->setPassword(
                    $passwordEncoder->encodePassword(
                        $user, $newPass
                    )

                );
                $entityManager->flush();
                $message = (new \Swift_Message('User'))
                    ->setFrom('taabaniesprit@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody("votre mot de passe :".$newPass);
                $mailer->send($message) ;
                return $this->redirectToRoute('app_user_profile');
            }
        }
        return $this->render('user/Rec.html.twig', [
            'user' => $user,
            'form' => $form->createView(),

        ]);
    }
    /**
     * @Route("/activedesactive/{id}", name="activedesactive", methods={"GET", "POST"})
     */
    public function activedesactive(Request $request, EntityManagerInterface $entityManager,$id): Response
    {
        $user = new User();
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);

        if($user->getAcces()=='non') {
            $user->setAcces('oui');
        }else {
            $user->setAcces('non');
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/stat/gen",name="statistiquesss")
     */

    public function statistiques(UserRepository $userRepository): Response
    {
    //    $p=$this->getDoctrine()->getRepository(User::class);
        $nbs = $userRepository->getNb();
        $data = [['Gender', 'Nombre ']];

        foreach($nbs as $nb)
        {
            $data[] = array(
                $nb['gen'], $nb['loo'])
            ;
        }
        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable(
            $data
        );
        $bar->getOptions()->setTitle('stat');
        $bar->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);
        return $this->render('user/Stat.html.twig',
            array('piechart' => $bar,'nbs' => $nbs));

    }


    /**
     * @param Request $request
     * @return Response
     * @Route ("/userajax/aa",name="searchuserrr")
     */
    public function searchuser(Request $request,UserRepository $userRepository)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $requestString=$request->get('searchValue');
        $rdv = $userRepository->findrdvBydate($requestString);
        return $this->render('user/userajax.html.twig' ,[
            "users"=>$rdv,
        ]);
    }

    /**
     * @Route("/pdf/user", name="imprimer", methods={"GET"})
     */
    public function pdf(UserRepository $userRepository): Response
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('user/pdf.html.twig', [
            'users' => $userRepository->findAll(),
        ]);

        $dompdf->loadHtml($html);


        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();


        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

}
