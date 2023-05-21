<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('titreMenu', 'Titre sur menu'),
            TextField::new('titreCarte', 'Titre sur carte'),
        ];
    }
}
