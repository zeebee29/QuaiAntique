<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestauController extends AbstractController
{
    #[Route('/restau', name: 'app_restau')]
    public function index(ImageRepository $imgRepo): Response
    {
        $images = $imgRepo->findByNomField('CarousselH');
        //dd($images);
        return $this->render('restau/restau.html.twig', [
            'controller_name' => 'RestauController',
            'images' => $images,
        ]);
    }
}
