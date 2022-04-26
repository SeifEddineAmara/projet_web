<?php

namespace App\Controller;

use App\Search\EvenementSearchData;
use App\Entity\Artiste;
use App\Entity\Evenement;
use App\Entity\Restaurant;
use App\Entity\TypeDeMusique;
use App\Form\SearchEvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

/**
 * @Route("/evenement/browser")
 */
class EvenementBrowserController extends AbstractController
{
    /**
     * @Route("/", name="app_evenement_browser_index", methods={"GET","POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager,
                          EvenementRepository $repository): Response
    {
        $data = new EvenementSearchData();
        $form = $this->createForm(SearchEvenementType::class, $data);
        $form->handleRequest($request);

        $evenements = $repository->findSearch($data);

        return $this->render('evenement_browser/index.html.twig', [
            'form' => $form->createView(),
            'evenements' => $evenements,
        ]);
    }

    /**
     * @Route ("/stats", name="app_evenement_browser_stats")
     */
    public function pieChart(EntityManagerInterface $entityManager){
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();
        $genres = $entityManager
            ->getRepository(TypeDeMusique::class)
            ->findAll();
        $chartData = array(['Genre', 'Nombre d\'événements']);

        foreach ($genres as $genre){
            $i = 0;
            foreach ($evenements as $evenement){
                if ($evenement->getArtiste()->getTypeDeMusique() == $genre){
                    $i++;
                }
            }
            if ($i != 0){
                $x = array_push($chartData, [
                    $genre->getGenre(),
                    $i
                ]);
            }
        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable($chartData);
        $pieChart->getOptions()->setTitle('Nombre d\'événements par genre');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('evenement_browser/pieChart.html.twig',['piechart' => $pieChart]);

    }

    private function intersectSearch($search) : ?array{
        $evenements = null;
        foreach ($search as $l){
            foreach ($l as $e){
                if (!in_array($e , $evenements)){
                    $i = array_push($evenements, $e);
                }
            }
        }
        return $evenements;
    }
}
