<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;

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
            DateTimeField::new('dateReservation', 'Jour réservé')->setFormat('yyyy/MM/dd HH:mm'),
            DateTimeField::new('createdAt', 'Date création')->setFormat('yyyy-MM-dd HH:mm')->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('modifiedAt', 'Modifié le')->setFormat('yyyy-MM-dd HH:mm')->setFormTypeOption('disabled', 'disabled'),
            IntegerField::new('nbConvive', 'Nbre de couverts'),
            TextEditorField::new('midiSoir', 'Plage'),
            TextEditorField::new('allergie', 'Allergie signalée'),
        ];
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('dateReservation')
            ->add('midiSoir')
            ->add('user')
            ->add('createdAt')
            ->add('modifiedAt')
        ;
    }
}
