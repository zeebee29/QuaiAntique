<?php

namespace App\Controller;

use App\Entity\OuvertureHebdo;
use App\Repository\OuvertureHebdoRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends AbstractController
{
    public function plageOuverture(OuvertureHebdoRepository $ouvertureHebdoRepository): Response
    {
        $heures = $ouvertureHebdoRepository->findAll();

        return $this->render('partial/_horaires.html.twig', [
            'heures' => $heures,
        ]);
    }
    public function toutesCoordonnees(RestaurantRepository $restauRepo): Response
    {
        $coord = $restauRepo->findCoordonnees();
        //dd($coord);
        return $this->render('partial/_coordonnees.html.twig', [
            'coord' => $coord[0],
        ]);
    }
}
