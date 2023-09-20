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
use Doctrine\ORM\EntityManagerInterface;
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

        //récupère le nombre maximum de réservation en ligne
        $nbMaxReservation = 10;

        $idUser= null;
        if (($this->getUser()) && ($this->getUser() === $user)) {
            //user connected AND user connected <> #id transmitted
            $resa->setNbConvive($user->getNbConvive());
            $idUser = $user->getId(); // pour le transmettre au 2nd volet de la réservation
        }
        else {
            $resa->setNbConvive(1);
        }
        $form = $this->createForm(ReservationType::class,$resa);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $resa = $form->getData();

            $nbConvive = $resa->getNbConvive();

            if ($nbConvive > 10) {
                $this->addflash('warning', 'Pour un nombre de couverts supérieur à 10, nous contacter.');
            } elseif ($nbConvive < 1) {
                $this->addflash('warning', 'Erreur sur le nombre de couverts.');
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
            'maxReservation' => $nbMaxReservation,
            'nbConvive' => $resa->getNbConvive(),
            'pageR' => 'OK',
        ]);
    }

    /*
     * renvoie les jours complets et la table des ouvertures/fermetures Hebdo  
     */
    #[Route('/reservation2/{nb}/{id?}', name: 'reservation2_dispo', methods: ['GET', 'POST'])]
    public function consultDispo(Request $request,int $nb, PlageReservationRepository $plageReservationRepository, ReservationRepository $reservationRepository, OuvertureHebdoRepository $ouvertureHebdoRepository, ?User $user=null): Response
    {
        //récupère le nombre maximum de réservation en ligne
        $nbMaxReservation = 10;
        if (($nb > $nbMaxReservation) || ($nb < 1)) {
            $this->addflash('warning', 'Erreur sur le nombre de couverts.');
        
            if ($user === null) {
                return $this->redirectToRoute('reservation1',);
            }
            else {
                return $this->redirectToRoute('reservation1',['id' => $user->getId(),]);
            }
        }
        $resa = new Reservation();
        $jClos = $ouvertureHebdoRepository->findFermeture();
        $plages = $plageReservationRepository->findAllPlages();

        //récupère les réservations non passées par dates/plages avec somme des convives
        $plagesCompletes = $reservationRepository->findNotDispoAfter(new DateTime(), $nb);
//dd($plagesCompletes);
        $form = $this->createForm(Reservation2Type::class, $resa);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $resa = $form->getData();

            if(is_null($user)) {
                return $this->redirectToRoute(
                    'reservation3_confirm',
                    [
                        'nb' => $nb,
                        'dateResaTxt' => $resa->getDateReservation()->format('Y-m-d H:i:s'),
                        ]
                );
            } else {
                return $this->redirectToRoute(
//                    'reservation3_userConfirm',
                    'reservation3_confirm',
                    [
                        'nb' => $nb,
                        'dateResaTxt' => $resa->getDateReservation()->format('Y-m-d H:i:s'),
                        'id'=> $user->getId(),
                    ]
                );
            }
        }
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
    public function requestUserComplement(Request $request, int $nb, $dateResaTxt,
         ReservationRepository $reservationRepository,
         OuvertureHebdoRepository $ouvertureHebdoRepository,
         RestaurantRepository $restaurantRepository,
         EntityManagerInterface $entityManager,
         ?User $user=null): Response
    {
        $anonymous = true;
        if (($this->getUser()) && ($this->getUser() === $user)) {
            //user connected AND user connected = #id transmitted
            $anonymous = false;
        }
        //récupère le nombre maximum de réservation en ligne
        $nbMaxReservation = 10;

        if (($nb > $nbMaxReservation) || ($nb < 1)) {
            $this->addflash('warning', 'Erreur sur le nombre de couverts.');
        
            if ($user === null) {
                return $this->redirectToRoute('reservation1',);
            }
            else {
                return $this->redirectToRoute('reservation1',['id' => $user->getId(),]);
            }
        }
        //Init d'un objet Reservation avec données saisies
        $resa = new Reservation();
        $resa->setNbConvive($nb);

        $dateResa = DateTime::createFromFormat('Y-m-d H:i:s', $dateResaTxt);
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

        if (($form->isSubmitted()) && ($form->isValid())) {
            //-1- vérifier que les dispos sont tjrs dispos
            //vérifie que la date demandée est future
            $today = new DateTime();

            if ($today > $dateResa) {
                $this->addflash('warning', 'La date choisie est indisponible.');
                return $this->redirectToRoute(
                    'reservation2_dispo',
                    [
                        'nb' => $nb,
                        'id'=> $user->getId(),
                        ]
                );
            }
            //vérifie que restaurant est ouvert
            $resultat = $ouvertureHebdoRepository->litEtatJourPlage($dateResa->format('N'), $plageTxt);
            if ($resultat[0]['h_ouverture'] === null) {            
                $this->addflash('warning', 'La date choisie est indisponible.');
                return $this->redirectToRoute(
                    'reservation2_dispo',
                    [
                        'nb' => $nb,
                        'id'=> $user->getId(),
                        ]
                );
            } else {
                //vérifie dispo pour x personnes pour le jour et la plage choisie
                //au cas où, recherche que dans le futur.
                //si retour = vide c'est dispo
                //dd($today, $nb, $dateResaTxt, $plageTxt);
                $resultat = $reservationRepository->testDispoAfter($today, $nb, $dateResaTxt, $plageTxt);
                //dd($today, $dateResaTxt);
                if(!empty($resultat)) {
                    //Si plus dispo => message et retour sur réservation
                    $nonDispoDate = $dateResa->format('d/m/Y');
                    if(1 === $nb) {
                        $this->addflash('warning', 'Après vérification, il n\'y a plus de place disponible le '.$nonDispoDate.' '.$plageTxt.'.');
                    }
                    else {
                        $this->addflash('warning', 'Après vérification, il n\'y a plus de place disponible pour '.$nb.' personnes le '.$nonDispoDate.' '.$plageTxt.'.');
                    }                    
                    return $this->redirectToRoute(
                        'reservation2_dispo',
                        [
                            'nb' => $nb,
                            'id'=> $user->getId(),
                            ]
                    );
                }
            }
            $resa->setStatus('Confirmé');
            $idRestau = $restaurantRepository->getId();
            $resa->setRestaurant($restaurantRepository->find($idRestau[0]['id']));

            //-2- création réservation avec
            $entityManager->persist($resa);
            $entityManager->flush();
            $this->addflash('success', 'Votre réservation a été enregistrée. Confirmez-la grâce au lien envoyé dans votre boite mail.');
            
            return $this->redirectToRoute("homepage");

            // status = attente
            // si user connecté, lien vers user
            // envoi msg+ lien confirmation + lien annulation
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
