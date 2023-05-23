<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Form\DisponibiliteType;
use App\Form\ReservationType;
use App\Repository\OuvertureHebdoRepository;
use App\Repository\PlageReservationRepository;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
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
            'nbConvive' => $resa->getNbConvive()
        ]);
    }

    /*
     * renvoie les jours complets et la table des ouvertures/fermetures Hebdo  
     */
    #[Route('/reservation/{nb}', name: 'app_resa_dispo')]
    public function consultDispo(Request $request, $nb, PlageReservationRepository $plageReservationRepository, ReservationRepository $reservationRepository, OuvertureHebdoRepository $ouvertureHebdoRepository): Response
    {
        $resa = new Reservation();
        $jClos = $ouvertureHebdoRepository->findFermeture();
        $plages = $plageReservationRepository->findAllPlages();

        //récupère les réservations non passées par dates/plages avec somme des convives
        $plagesCompletes = $reservationRepository->findNotDispoAfter(new DateTime(), $nb);

        $form = $this->createForm(DisponibiliteType::class, $resa);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $resa = $form->getData();
            $dateResa = $request->request->get('date-confirm-in');

            //vérif que date/heure OK et place toujours dispo
            //test si dans la liste des fermetures

            $nbConvive = $resa->getNbConvive();
            //test si nbConvives toujours OK sur la plage horaire
            //si c'est OK, pas de msg et on passe à la suite
            return $this->redirectToRoute(
                'app_resa_complement',
                [
                    'nb' => $nb,
                    'dateResa' => $dateResa,
                ]
            );
        }

        return $this->render('reservation/disponibilite.html.twig', [
            'form' => $form->createView(),
            'plagesCompletes' => json_encode($plagesCompletes),
            'hebdo' => json_encode($jClos),
            'plagesH' => json_encode($plages),
            'nbPers' => $nb,
            'dateReservation' => $resa->getDateReservation(),

        ]);
    }


    #[Route('/reservation3/{nb}{dateResa}', name: 'app_resa_complement')]
    public function requestCompl(Request $request, $nb, $dateResa, User $user, UserRepository $userRepo): Response
    {


        if (!$this->getUser()) {
            //l'utilisateur n'est pas connecté
            //alors pas de requête pour récupérer ses infos

        } else { //utilisateur connecté, on récupère ses infos


        }
        $resa = new Reservation();

        $form = $this->createForm(Reservation3Type::class, $resa);
        $form->handleRequest($request);

        return $this->render('reservation/reservation3.html.twig', [
            'form' => $form->createView(),
            'nb' => $nb,
            'dateReservation' => $dateResa

        ]);
    }
}
