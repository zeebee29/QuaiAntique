<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function menus(): Response
    {
        return $this->render('plat/menu.html.twig', [
            'controller_name' => 'PlatController',
        ]);
    }

    #[Route('/plat', name: 'app_plat')]
    public function carte(): Response
    {
        return $this->render('plat/plat.html.twig', [
            'controller_name' => 'PlatController',
        ]);
    }
}