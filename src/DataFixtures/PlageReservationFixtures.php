<?php

namespace App\DataFixtures;

use App\Entity\PlageReservation;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlageReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $plagesResa = [
            ["midi", new DateTime('2023-01-01 12:00:00'),],
            ["midi", new DateTime('2023-01-01 12:15:00'),],
            ["midi", new DateTime('2023-01-01 12:30:00'),],
            ["midi", new DateTime('2023-01-01 12:45:00'),],
            ["midi", new DateTime('2023-01-01 13:00:00'),],
            ["midi", new DateTime('2023-01-01 13:15:00'),],
            ["midi", new DateTime('2023-01-01 13:30:00'),],
            ["soir", new DateTime('2023-01-01 20:00:00'),],
            ["soir", new DateTime('2023-01-01 20:15:00'),],
            ["soir", new DateTime('2023-01-01 20:30:00'),],
            ["soir", new DateTime('2023-01-01 20:45:00'),],
            ["soir", new DateTime('2023-01-01 21:00:00'),],
            ["soir", new DateTime('2023-01-01 21:15:00'),],
            ["soir", new DateTime('2023-01-01 21:30:00'),],
        ];

        foreach ($plagesResa as [$midiSoir, $hPlage]) {
            $resa = new PlageReservation();
            $resa->setMidiSoir($midiSoir)
                ->setHeurePlage($hPlage);
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
