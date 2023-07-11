<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
class ReservationFixtures extends Fixture implements DependentFixtureInterface
{

        /**
     * @var Generator
     */
    private Generator $faker;


    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        $resaExamples = [
            ['user0', new DateTime('2023-05-17 12:45:00'), "midi", 2, null, new DateTime('2023-04-18 14:30:00'), null, "Confirmé"],
            ['user1', new DateTime('2023-06-17 21:00:00'), "soir", 5, null, new DateTime('2023-04-18 21:31:00'), null, "Confirmé"],
            ['user2', new DateTime('2023-10-18 12:00:00'), "midi", 7, null, new DateTime('2020-04-18 07:31:00'), null, "Confirmé"],
            ['user3', new DateTime('2023-10-18 12:30:00'), "midi", 1, null, new DateTime('2020-04-18 07:31:00'), null, "Confirmé"],
            ['user4', new DateTime('2023-10-18 12:45:00'), "midi", 1, null, new DateTime('2020-04-18 07:31:00'), null, "Confirmé"],
            ['user2', new DateTime('2023-10-19 20:00:00'), "soir", 7, null, new DateTime('2020-04-18 07:31:00'), null, "Confirmé"],
            ['user4', new DateTime('2023-10-19 20:00:00'), "soir", 1, null, new DateTime('2020-04-18 07:31:00'), null, "Confirmé"],
            ['user0', new DateTime('2023-10-20 12:00:00'), "midi", 5, null, new DateTime('2020-04-18 07:31:00'), null, "Confirmé"],
            ['user4', new DateTime('2023-10-21 12:00:00'), "midi", 9, null, new DateTime('2020-04-18 07:31:00'), null, "Confirmé"],
            ['user1', new DateTime('2023-10-17 12:00:00'), "midi", 7, null, new DateTime('2020-04-18 07:31:00'), null, "Confirmé"],
        ];

        foreach ($resaExamples as [$user, $dateResa, $midiSoir, $nbConvive, $allergie, $createdAt, $modifAt, $status]) {
            $resa = new Reservation();
            $resa->setUser($this->getReference($user))
                ->setDateReservation($dateResa)
                ->setMidiSoir($midiSoir)
                ->setNbConvive($nbConvive)
                ->setAllergie($allergie)
                ->setCreatedAt($createdAt)
                ->setStatus($status)
                ->setTelReserv($this->faker->regexify('/^(\+33|0)[0-9]{9}$/'))
                ->setEmail($this->faker->email())
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
