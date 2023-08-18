<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\ReservationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/edition/{id}', name: 'user.edit')]
    /**
     * Contrôleur pour modification de profil
     * 
     * @param User $user
     * @param Request $requets
     * @param EntityManager $manager
     * @return Response
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('security.logout');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addflash('success', 'Votre profil a bien été modifié.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Contrôleur pour modification de mot de passe
     * 
     * @param User $user
     * @param Request $requets
     * @param EntityManager $manager
     * @return Response
     */
    #[Route('/user/editPassword/{id}', 'user-edit-passsword', methods: ['GET', 'POST'])]
    public function editPassword(Request $request, EntityManagerInterface $manager, User $user, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('security.logout');
        }

        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setPlainPassword($form->getData()['newPassword']);
                $user->setUpdatedAt(new DateTime());

                $manager->persist($user);
                $manager->flush();

                $this->addflash('success', 'Votre mot de passe a été modifié.');

                return $this->redirectToRoute('homepage');
            } else {
                $this->addflash('warning', 'Erreur sur mot de passe actuel.');
            }
        }

        return $this->render('user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/history/{id}', 'user-booking', methods: ['GET', 'POST'])]
    public function bookingHistory(Request $request, User $user, ReservationRepository $reservRepo): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('security.logout');
        }

        return $this->render('user/book_history.html.twig', [
            'bookings' => $reservRepo->findByUserField($user),
        ]);
    }


}
