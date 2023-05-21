<?php

namespace App\Controller\Admin;

use App\Entity\PlageReservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class PlageReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlageReservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('midiSoir', 'Nom'),
            TimeField::new('heurePlage', 'Plage')->setFormat('HH:mm'),
        ];
    }
}
