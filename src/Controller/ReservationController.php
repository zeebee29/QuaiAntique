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
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\IsNull;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{id?}', name: 'reservation1', methods: ['GET', 'POST'])]
    public function startResa(Request $request, ?User $user): Response
    {
        $resa = new Reservation();
        $form = $this->createForm(ReservationType::class,$resa);
        $form->handleRequest($request);
        $idUser= null;
        if (($this->getUser()) && ($this->getUser() === $user)) {
            //user connected AND user connected <> #id transmitted
            $resa->setNbConvive($user->getNbConvive());
            $idUser = $user->getId(); // pour le transmettre au 2nd volet de la réservation
        }
        else {
            $resa->setNbConvive(1);
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
            'nbConvive' => $resa->getNbConvive(),
            'pageR' => 'OK',
        ]);
    }

    /*
     * renvoie les jours complets et la table des ouvertures/fermetures Hebdo  
     */
    #[Route('/reservation2/{nb}/{id?}', name: 'reservation2_dispo', methods: ['GET', 'POST'])]
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
            if(is_null($user)) {
                return $this->redirectToRoute(
                    'reservation3_confirm',
                    [
                        'nb' => $nb,
                        'dateResaTxt' => $resa->getDateReservation()->format('Ymd His'),
                        ]
                );
            } else {
                return $this->redirectToRoute(
//                    'reservation3_userConfirm',
                    'reservation3_confirm',
                    [
                        'nb' => $nb,
                        'dateResaTxt' => $resa->getDateReservation()->format('Ymd His'),
                        'id'=> $user->getId(),
                    ]
                );
            }
        }
        var_dump($resa->getDateReservation());
        return $this->render('reservation/reservation2.html.twig', [
            'form' => $form->createView(),
            'plagesCompletes' => json_encode($plagesCompletes),
            'hebdo' => json_encode($jClos),
            'plagesH' => json_encode($plages),
            'nbPers' => $nb,
            'pageR' => 'OK',
        ]);
    }
    #[Route('/reservation3/{nb}/{dateResaTxt}/{id?}', name: 'reservation3_confirm', methods: ['GET', 'POST'])]
    public function requestUserCompl(Request $request, int $nb, $dateResaTxt, ?User $user): Response
    {
        $anonymous = true;
        if (($this->getUser()) && ($this->getUser() === $user)) {
            //user connected AND user connected = #id transmitted
            $anonymous = false;
        }

        //Init d'un objet Reservation avec données saisies
        $resa = new Reservation();
        $resa->setNbConvive($nb);

        $dateResa = DateTime::createFromFormat('Ymd His', $dateResaTxt);
        $resa->setDateReservation($dateResa);
        if (!$anonymous) {
            $resa->setUser($user);
            $resa->setTelReserv($user->getTel());
            $resa->setEmail($user->getEmail());
            $resa->setAllergie($user->getAllergie());
        }
        
        $heureBascule = '16:00';
        $heureResa = $dateResa->format('H:i:s');
        $plageTxt = ($heureResa > $heureBascule) ? "soir" : "midi";
        $resa->setMidiSoir($plageTxt);

        //création formulaire pour validation finale
        $form = $this->createForm(Reservation3Type::class,$resa);
        //pré-remplissage du formulaire avec les mêmes données (en lecture seule normalement)
        $form->get('dateReservation')->setData($dateResa);
        $form->get('midiSoir')->setData($plageTxt);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                dd('VALID');
            } 
        }
        if (!$anonymous) {
            return $this->render('reservation/reservation3.html.twig', [
                'form' => $form->createView(),
                'prenom' => $user->getPrenom(),
                'pageR' => 'OK',
            ]);
        }
        else {
            return $this->render('reservation/reservation3.html.twig', [
                'form' => $form->createView(),
                'prenom' => '',
                'pageR' => 'OK',
            ]);
        }
    }


}
