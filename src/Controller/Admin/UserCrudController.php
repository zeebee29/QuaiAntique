<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            AssociationField::new('reservations', 'Réservations')->setFormTypeOption('disabled', 'disabled'),
            TextField::new('nom', 'Nom')
                ->setRequired(true)
                ->setFormTypeOption('constraints', [
                    new NotBlank(),
                ]),
            TextField::new('prenom', 'Prénom')
                ->setRequired(false)
                ->setFormTypeOption('constraints', [
                    new NotBlank(),
                ]),
            EmailField::new('email', 'Email')
                ->setRequired(true),
            TextField::new('password')
                ->hideOnForm()
                ->hideOnIndex(),
            ArrayField::new('roles')
                ->hideOnForm()
                ->hideOnIndex(),
            TextField::new('tel', 'Tél.')
                ->setRequired(true)
                ->setFormTypeOption('constraints', [
                    new NotBlank(),
                ]),
            IntegerField::new('nbConvive', 'Nbre convive(s)'),
            TextEditorField::new('allergie', 'Allergie signalée'),
        ];
    }
}
