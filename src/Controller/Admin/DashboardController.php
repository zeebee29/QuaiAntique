<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Image;
use App\Entity\Menu;
use App\Entity\PlageReservation;
use App\Entity\OuvertureHebdo;
use App\Entity\Plat;
use App\Entity\Reservation;
use App\Entity\Restaurant;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function dashBoardAdmin(): Response
    {
        $url = $this->adminUrlGenerator->setController(ReservationCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration - Le Quai Antique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Menus & Plats');
        yield MenuItem::subMenu('Menus', 'fas fa_bars')->setSubItems([
            MenuItem::linkToCrud('Créer', 'fas fa-plus', Menu::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', Menu::class)
        ]);
        //yield MenuItem::section('Plats');
        yield MenuItem::subMenu('Plats', 'fas fa_bars')->setSubItems([
            MenuItem::linkToCrud('Créer', 'fas fa-plus', Plat::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', Plat::class)
        ]);
        //yield MenuItem::section('Catégories');
        yield MenuItem::subMenu('Catégories', 'fas fa_bars')->setSubItems([
            MenuItem::linkToCrud('Créer', 'fas fa-plus', Categorie::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', Categorie::class)
        ]);

        yield MenuItem::section('_____________________________');
        yield MenuItem::section('Ouvertures & Fermetures');
        yield MenuItem::subMenu('Horaires', 'fas fa_bars')->setSubItems([
            //MenuItem::linkToCrud('Création Horaires', 'fas fa-plus', OuvertureHebdo::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', OuvertureHebdo::class)
        ]);
        //yield MenuItem::section('Plages de réservation');
        yield MenuItem::subMenu('Plages', 'fas fa_bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', PlageReservation::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', PlageReservation::class)
        ]);
        /*
        //yield MenuItem::section('_____________________________');
        //yield MenuItem::section('Fermeture');
        yield MenuItem::subMenu('Jours fermeture', 'fas fa_bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Fermeture::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', Fermeture::class)
        ]);*/
        yield MenuItem::section('_____________________________');
        yield MenuItem::section('Admin. Clients');
        yield MenuItem::subMenu('Réservations', 'fas fa_bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Reservation::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', Reservation::class)
        ]);
        yield MenuItem::subMenu('Clients', 'fas fa_bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', User::class)
        ]);

        yield MenuItem::section('_____________________________');
        yield MenuItem::section('Le restaurant');
        yield MenuItem::subMenu('Paramètres', 'fas fa_bars')->setSubItems([
            //MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Reservation::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fas fa-eye', Restaurant::class)
        ]);
        yield MenuItem::subMenu('Photos', 'fas fa_bars')->setSubItems([
            //MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Reservation::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier', 'fa-solid fa-camera', Image::class)
        ]);
    }
}
