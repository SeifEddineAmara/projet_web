<?php

namespace App\Controller\Mobile;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mobile/user")
 */
class UserMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        if ($users) {
            return new JsonResponse($users, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/show", methods={"POST"})
     */
    public function show(Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->find((int)$request->get("id"));

        if ($user) {
            return new JsonResponse($user, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();

        return $this->manage($user, $request, false, $passwordEncoder);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $userRepository->find((int)$request->get("id"));

        if (!$user) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($user, $request, true, $passwordEncoder);
    }

    public function manage($user, $request, $isEdit, $passwordEncoder): JsonResponse
    {

        if (!$isEdit) {
            $checkEmail = $this->getDoctrine()->getRepository(User::class)
                ->findOneBy(["email" => $request->get("email")]);

            if ($checkEmail) {
                return new JsonResponse("Email already exist", 203);
            }
        }

        $user->setUp(
            $request->get("name"),
            $request->get("lastname"),
            $request->get("email"),
            $request->get("gender"),
            (float)$request->get("phone"),
            DateTime::createFromFormat("d-m-Y", $request->get("birthday")),
            "oui",
            $request->get("roles")
        );

        if (!$isEdit) {
            $pjava="".substr($request->get("password")->getData(), 0, 3).'nisqpfdbn$hreb6b8e6'.substr($request->get("password")->getData(), 3, 255);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->get("password")));
            $user->setPasswordjava($pjava);
            $user->setRole('client');
            $email = $user->getEmail();
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                try {
                    $transport = new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl');
                    $transport->setUsername('pidev.app.esprit@gmail.com')->setPassword('pidev-cred');
                    $mailer = new Swift_Mailer($transport);
                    $message = new Swift_Message('Welcome');
                    $message->setFrom(array('pidev.app.esprit@gmail.com' => 'Bienvenu'))
                        ->setTo(array($user->getEmail() => $user->getEmail()))
                        ->setBody("<h1>Bienvenu a notre application</h1>", 'text/html');
                    $mailer->send($message);
                }catch (\Exception $e){

                }
            }
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($user, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find((int)$request->get("id"));

        if (!$user) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        foreach ($users as $user) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/verif", methods={"POST"})
     */
    public function verif(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $userRepository->findOneBy(["email" => $request->get("email")]);

        if ($user) {
            if ($passwordEncoder->isPasswordValid($user, $request->get("password"))) {
                return new JsonResponse($user, 200);
            } else {
                return new JsonResponse("user found but pass wrong", 203);
            }
        } else {
            return new JsonResponse([], 204);
        }
    }
}
