<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestauController extends AbstractController
{
    #[Route('/restau', name: 'app_restau')]
    public function index(ImageRepository $imgRepo): Response
    {
        $images = $imgRepo->findByNomField('Nous');
        //dd($images);
        return $this->render('restau/restau.html.twig', [
            'controller_name' => 'RestauController',
            'images' => $images,
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(RestaurantRepository $restauRepo): Response
    {
        $coord = $restauRepo->findCoordonnees();
        //dd($coord);
        return $this->render('restau/contact.html.twig', [
            'coord' => $coord[0],
        ]);
    }
}