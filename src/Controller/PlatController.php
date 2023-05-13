<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PlatController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function menus(MenuRepository $menuRepository): Response
    {
        return $this->render('plat/menu.html.twig', [
            'menus' => $menuRepository->findAll(),
        ]);
    }

    #[Route('/carte', name: 'app_carte')]
    public function carte(PlatRepository $platRepository, CategorieRepository $categorieRepository): Response
    {
        $plats = $platRepository->findAllinCarte();
        $categories = $categorieRepository->findAll();
        //dd($categories, $plats);
        return $this->render('plat/plat.html.twig', [
            'categories' => $categories,
            'plats' => $plats,
        ]);
    }

    #[Route('/plats', name: 'app_plats')]
    #[IsGranted('ROLE_ADMIN')]
    public function plats(PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findAll();
        dd($plats);
        return $this->render('plat/plat.html.twig', [
            'plats' => $plats,
        ]);
    }
}
