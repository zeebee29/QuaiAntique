<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    #[Route('/accueil', name: 'accueil.home')]
    public function home(ImageRepository $imgRepo): Response
    {
        $imagesC = $imgRepo->findByNomField('CarousselH');
        $accueil = $imgRepo->findByNomField('Accueil');
        $images = $imgRepo->findByNomField('Plat');
        //dd($images);
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'imagesCarousel' => $imagesC,
            'accueil' => $accueil,
            'images' => $images,
        ]);
    }
}
