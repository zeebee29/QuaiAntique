<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\NotNull;

class MenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('nom', 'Nom')
                //->setFormTypeOption('required', true)
                ->setFormTypeOption('constraints', [
                    new NotNull()
                ]),
            AssociationField::new('plats', 'Plats'),
            TextEditorField::new('description', 'Description'),
            MoneyField::new('prix', 'Prix')->setCurrency('EUR')->setCustomOption('storedAsCents', false),
        ];
    }
}
