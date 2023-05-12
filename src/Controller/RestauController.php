<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestauController extends AbstractController
{
    #[Route('/restau', name: 'app_restau')]
    public function index(): Response
    {
        return $this->render('restau/restau.html.twig', [
            'controller_name' => 'RestauController',
        ]);
    }
}
