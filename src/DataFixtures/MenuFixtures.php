<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Menu;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $entreeRef  = $this->getReference('entree_menu');
        $platRef    = $this->getReference('plat_menu');
        $dessertRef = $this->getReference('dessert_menu');

        $menuExamples = [
            ['Menu Déjeuner (Entrée + Plat)', 20.00, $entreeRef, $platRef, NULL],
            ['Menu Déjeuner (Plat + Dessert)', 20.00, $platRef, $dessertRef, NULL],
            ['Menu Déjeuner Complet', 26.00, $entreeRef, $platRef, $dessertRef],
        ];

        foreach ($menuExamples as [$name, $price, $plat1, $plat2, $plat3]) {
            $menu = new Menu();
            $menu->setNom($name);
            $menu->setPrix($price);
            $menu->addPlat($plat1);
            $menu->addPlat($plat2);
            if (!is_null($plat3)) {
                $menu->addPlat($plat3);
            }

            $manager->persist($menu);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            PlatFixtures::class,
        ];
    }
}
