<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $resaExamples = [
            ['user0', new DateTime('2023-07-17 12:45:00'), 2, null, new DateTime('2023-04-18 14:30:00'), null,],
            ['user1', new DateTime('2023-06-03 21:00:00'), 5, null, new DateTime('2023-04-18 21:31:00'), null,],
            ['user2', new DateTime('2020-01-01 12:00:00'), 7, null, new DateTime('2020-04-18 07:31:00'), null,],
        ];

        foreach ($resaExamples as [$user, $dateResa, $nbConvive, $allergie, $createdAt, $modifAt]) {
            $resa = new Reservation();
            $resa->setUser($this->getReference($user))
                ->setDateReservation($dateResa)
                ->setNbConvive($nbConvive)
                ->setAllergie($allergie)
                ->setCreatedAt($createdAt);
            //$resa->setModifiedAt($modifAt);
            $manager->persist($resa);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
