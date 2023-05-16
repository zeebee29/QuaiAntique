<?php

namespace App\Controller;

use App\Repository\PlageReservationRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisponibiliteController extends AbstractController
{
    #[Route('/plages', name: 'app_plages')]
    public function dispoMonth(PlageReservationRepository $plageReservationRepository): Response
    {
        $plagesResa = $plageReservationRepository->findAll();
        return $this->render('reservation/disponibilite.html.twig', [
            'plages' => $plagesResa,
        ]);
    }
}
