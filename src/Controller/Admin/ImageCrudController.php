<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('nom', 'Titre')->setFormTypeOption('disabled', true),
            TextareaField::new('description', 'Description'),
            VichImageField::new('imageFile'),
            AssociationField::new('restaurant'),
        ];

        if ($pageName === Crud::PAGE_EDIT) {
            $fields[] = TextField::new('nom', 'Titre')->setFormTypeOption('disabled', true);
        } else {
            $fields[] = TextField::new('nom', 'Titre');
        }

        return $fields;
    }
}
