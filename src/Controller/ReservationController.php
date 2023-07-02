<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Form\Reservation2Type;
use App\Form\Reservation3Type;
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
    #[Route('/reservation/{id?}', name: 'reservation1', methods: ['GET', 'POST'])]
    public function startResa(Request $request, ?User $user): Response
    {
        $resa = new Reservation();
        $form = $this->createForm(ReservationType::class);
        $form->handleRequest($request);
        $idUser= null;
        if (($this->getUser()) && ($this->getUser() === $user)) {//user connected AND user connected <> #id transmitted ?
            $resa->setNbConvive($user->getNbConvive());
            $idUser = $user->getId(); // pour le transmettre au 2nd volet de la réservation
        }

        if ($form->isSubmitted()) {
            $resa = $form->getData();
            $nbConvive = $resa->getNbConvive();

            if ($nbConvive > 10) {
                $this->addflash('warning', 'Pour un nombre de convives supérieur à 10, nous contacter.');
            } elseif ($nbConvive < 1) {
                $this->addflash('warning', 'Erreur sur le nombre de convives.');
            } else {
                //Nb saisi OK, on peut passer au calendrier
                //$this->addflash('success', 'nos dispos pour ' . $nbConvive . ' personne(s).');
                return $this->redirectToRoute(
                    'reservation2_dispo',
                    [
                        'nb' => $nbConvive,
                        'id' => $idUser,
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
    #[Route('/reservation2/{nb}/{id?}', name: 'reservation2_dispo')]
    public function consultDispo(Request $request,int $nb, PlageReservationRepository $plageReservationRepository, ReservationRepository $reservationRepository, OuvertureHebdoRepository $ouvertureHebdoRepository, ?User $user): Response
    {

        $resa = new Reservation();
        $jClos = $ouvertureHebdoRepository->findFermeture();
        $plages = $plageReservationRepository->findAllPlages();

        //récupère les réservations non passées par dates/plages avec somme des convives
        $plagesCompletes = $reservationRepository->findNotDispoAfter(new DateTime(), $nb);

        $form = $this->createForm(Reservation2Type::class, $resa);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $resa = $form->getData();
            
            //vérif que date/heure OK et place toujours dispo
            //test si dans la liste des fermetures

            $nbConvive = $resa->getNbConvive();
            //test si nbConvives toujours OK sur la plage horaire
            //si c'est OK, pas de msg et on passe à la suite
            return $this->redirectToRoute(
                'reservation3_confirm',
                [
                    'nb' => $nb,
                    'dateResa' => $resa->getDateReservation()->format('Y-m-d H:i:s'),
                    'id'=> $user->getId(),
                ]
            );
        }

        return $this->render('reservation/reservation2.html.twig', [
            'form' => $form->createView(),
            'plagesCompletes' => json_encode($plagesCompletes),
            'hebdo' => json_encode($jClos),
            'plagesH' => json_encode($plages),
            'nbPers' => $nb,
            'dateReservation' => $resa->getDateReservation(),

        ]);
    }


    #[Route('/reservation3/{nb}/{dateResa}/{id?}', name: 'reservation3_confirm')]
    public function requestCompl(Request $request, int $nb, $dateResa, UserRepository $userRepo, ?User $user): Response
    {
        var_dump($user->getId(), $nb, $dateResa);

        if (($this->getUser()) && ($this->getUser() === $user)) {//user connected AND user connected <> #id transmitted ?
        }

        $resa = new Reservation();

        $form = $this->createForm(Reservation3Type::class, $resa);
        $form->handleRequest($request);

        return $this->render('reservation/reservation3.html.twig', [
            'form' => $form->createView(),
            'nb' => $nb,
            'dateResa' => $dateResa

        ]);
    }
}
