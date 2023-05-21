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
            ['user0', new DateTime('2020-05-17 12:45:00'), "midi", 2, null, new DateTime('2023-04-18 14:30:00'), null,],
            ['user1', new DateTime('2023-05-17 21:00:00'), "soir", 5, null, new DateTime('2023-04-18 21:31:00'), null,],
            ['user2', new DateTime('2023-05-25 12:00:00'), "midi", 7, null, new DateTime('2020-04-18 07:31:00'), null,],
            ['user3', new DateTime('2023-05-25 12:30:00'), "midi", 1, null, new DateTime('2020-04-18 07:31:00'), null,],
            ['user4', new DateTime('2023-05-25 12:45:00'), "midi", 1, null, new DateTime('2020-04-18 07:31:00'), null,],
            ['user2', new DateTime('2023-05-27 20:00:00'), "soir", 7, null, new DateTime('2020-04-18 07:31:00'), null,],
            ['user4', new DateTime('2023-05-27 20:00:00'), "soir", 1, null, new DateTime('2020-04-18 07:31:00'), null,],
            ['user0', new DateTime('2023-05-28 12:00:00'), "midi", 5, null, new DateTime('2020-04-18 07:31:00'), null,],
            ['user4', new DateTime('2023-06-01 12:00:00'), "midi", 9, null, new DateTime('2020-04-18 07:31:00'), null,],
            ['user1', new DateTime('2023-06-02 12:00:00'), "midi", 7, null, new DateTime('2020-04-18 07:31:00'), null,],
        ];

        foreach ($resaExamples as [$user, $dateResa, $midiSoir, $nbConvive, $allergie, $createdAt, $modifAt]) {
            $resa = new Reservation();
            $resa->setUser($this->getReference($user))
                ->setDateReservation($dateResa)
                ->setMidiSoir($midiSoir)
                ->setNbConvive($nbConvive)
                ->setAllergie($allergie)
                ->setCreatedAt($createdAt)
                ->setRestaurant($this->getReference('restaurant'));
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
