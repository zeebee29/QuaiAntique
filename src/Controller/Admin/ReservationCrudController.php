<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            AssociationField::new('user', 'Client'),
            DateTimeField::new('dateReservation', 'Jour/heure réservé')->setFormat('dd/MM/yyyy HH:mm'),
            DateTimeField::new('createdAt', 'Date création')->setFormat('dd/MM/yyyy HH:mm')->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('modifiedAt', 'Modifié le')->setFormat('dd/MM/yyyy HH:mm')->setFormTypeOption('disabled', 'disabled'),
            IntegerField::new('nbConvive', 'Nbre de personnes'),
            TextEditorField::new('allergie', 'Allergie signalée'),
        ];
    }
}
