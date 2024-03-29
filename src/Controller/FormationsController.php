<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;



class FormationsController extends AbstractController
{
    /**
     * @Route("/formations", name="app_formations")
     */
    public function index(): Response
    {
        return $this->render('formations/index.html.twig', [
            'controller_name' => 'FormationsController',
        ]);
    }


    /**
     * @Route("/formations/EspaceFormation")
     */
    public function EspaceFormations(): Response
    {

        return $this->render('Formations/EspaceFormation.html.twig', ['controller_name' => 'FormationsController',]);
    }

    /**
     * @Route("/formations/Inscription")
     */
    public function Inscription(): Response
    {

        return $this->render('Formations/Inscription.html.twig', ['controller_name' => 'FormationsController',]);
    }


    /**
     * @Route("/formations/Inscription")
     */
    public function ExporterPDF(): Response
    {

        return $this->render('Formations/Inscription.html.twig', ['controller_name' => 'FormationsController',]);
    }

    /**
     * @Route("/formations/Inscription/Download", name="formations_download")
     */
    public function DownloadPDF(): Response
    {
        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancier Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // On génère le html
        $html = $this->renderView('formations/Download.html.twig');

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'cour.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }


    /**
     * @Route("/formations/Inscription/pdf")
     */
    public function PDF(): Response
    {

        return $this->render('Formations/pdf.html.twig', ['controller_name' => 'FormationsController',]);
    }

    /**
     * @Route("/formations/SendMail")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function Reservation(MailerInterface $mailer)
    {

        $email = (new TemplatedEmail())
            ->from('3a5pidev@gmail.com')
            ->to('salim.raboudi@esprit.tn')
            ->subject("Cour envoyée avec succée")
            ->htmlTemplate('formations/EnvoyerMail.html.twig')
            ->context([
                'formations' => "utlisateur inscrit"
            ])
        ;;
        $mailer->send($email);


        // ...
        return $this->render('formations/index.html.twig', [
            'controller_name' => 'FormationsController',
        ]);
    }
}



