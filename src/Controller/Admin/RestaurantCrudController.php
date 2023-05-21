<?php

namespace App\Controller\Admin;

use App\Entity\Restaurant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RestaurantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Restaurant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('tel', 'Tél.'),
            TextEditorField::new('adresse', 'Adresse'),
            IntegerField::new('capacite', 'Capacité'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->remove(Crud::PAGE_INDEX, Action::NEW);
        return $actions;
    }
}
