<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Menu;
use App\Entity\Plat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cat = [
            ['apéritif', 'Apéritifs', 'Nos apéritifs', 'category_aperitif'],
            ['entrées', 'Entrée', 'Nos entrées', 'category_entree'],
            ['plats', 'Plat', 'Nos plats', 'category_plat'],
            ['dessert', 'Dessert', 'Nos desserts', 'category_dessert'],
            ['alcool', 'Boissons', 'Nos boissons alcoolisées', 'category_alcool'],
            ['sans alcool', 'Boissons sans alcool', 'Nos boissons sans alcool', 'category_ss_alcool'],
            ['vins', 'Vins', 'Nos vins', 'category_vin']
        ];

        foreach ($cat as [$name, $titleMenu, $titleCard, $catName]) {
            $category = new Categorie();
            $category->setNom($name);
            $category->setTitreMenu($titleMenu);
            $category->setTitreCarte($titleCard);
            $manager->persist($category);
            $this->setReference($catName, $category);
        }

        $manager->flush();
    }
}
