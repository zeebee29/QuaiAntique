<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Contrôleur pour se connecter
     * 
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/login', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'form' => $form->createView()

        ]);
    }

    /**
     * Ce contrôleur déconnecte l'utilisateur
     * 
     * @return void
     */
    #[Route('/logout', name: 'security.logout')]
    public function logout()
    {
        //rien
    }

    /**
     * Ce contrôleur ppour s'inscrire
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/inscription', name: 'security.registration', methods: ['GET', 'POST'])]
    public function inscription(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();

        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addflash('success', 'Votre compte a bien été créé.');

            return $this->redirectToRoute('security.login');
        }
        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
