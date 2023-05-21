<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\OuvertureHebdoRepository;
use App\Repository\PlageReservationRepository;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /*
     * renvoie les jours complets et la table des ouvertures/fermetures Hebdo  
     */
    #[Route('/reservation/{nb}', name: 'app_resa_dispo')]
    public function consultDispo(Request $request, $nb, PlageReservationRepository $plageReservationRepository, ReservationRepository $reservationRepository, OuvertureHebdoRepository $ouvertureHebdoRepository): Response
    {
        $resa = new Reservation();
        $jClos = $ouvertureHebdoRepository->findFermeture();

        $plages = $plageReservationRepository->findAllPlages();

        //Contrôle si nbConvive est dans les limites

        //récupère les réservations non passées par dates/plages avec somme des convives
        $plagesCompletes = $reservationRepository->findNotDispoAfter(new DateTime(), $nb);

        $form = $this->createForm(ReservationType::class, $resa);
        $form->handleRequest($request);

        return $this->render('reservation/disponibilite.html.twig', [
            'form' => $form->createView(),
            'plagesCompletes' => json_encode($plagesCompletes),
            'hebdo' => json_encode($jClos),
            'plagesH' => json_encode($plages),
            'nbPers' => $nb,
        ]);
    }

    #[Route('/reservation', name: 'app_reservation', methods: ['GET', 'POST'])]
    public function startResa(Request $request): Response
    {
        $resa = new Reservation();

        $form = $this->createForm(ReservationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $resa = $form->getData();
            $nbConvive = $resa->getNbConvive();
            if ($nbConvive > 10) {
                $this->addflash('warning', 'Pour un nombre de convives suéprieur à 10, nous contacter.');
            } elseif ($nbConvive < 1) {
                $this->addflash('warning', 'Erreur sur le nombre de convives.');
            } else {
                //Nb saisi OK, on peut passer au calendrier
                $this->addflash('success', 'nos dispos pour ' . $nbConvive . ' personne(s).');

                return $this->redirectToRoute(
                    'app_resa_dispo',
                    [
                        'nb' => $nbConvive,
                    ]
                );
            }
        }
        return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView(),
            $resa->getNbConvive()
        ]);
    }
}
