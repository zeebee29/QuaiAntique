<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RestaurantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $restau = new Restaurant();
        $restau->setAdresse('1 avenue Lorem Ipsum - XXXXX CHAMBERY');
        $restau->setTel('0102030405');
        $restau->setCapacite(95);
        $restau->setGapResa(15);
        $restau->setDelayBeforeEnd(60);
        $manager->persist($restau);

        $manager->flush();
    }
}
