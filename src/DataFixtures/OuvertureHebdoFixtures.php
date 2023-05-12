<?php

namespace App\DataFixtures;

use App\Entity\OuvertureHebdo;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OuvertureHebdoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ouvertureExamples = [
            ['lundi',    new DateTime('2020-01-01 12:30:00'), new DateTime('2020-01-01 14:30:00'), 'resaLundiMidi',],
            ['lundi',    new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), 'resaLundiSoir',],
            ['mardi',    new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), 'resaMardiMidi',],
            ['mardi',    new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), 'resaMardiSoir',],
            ['jeudi',    new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), 'resaJeudiMidi',],
            ['jeudi',    new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), 'resaJeudiSoir',],
            ['vendredi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), 'resaVendrediMidi',],
            ['vendredi', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), 'resaVendrediSoir',],
            ['samedi',   new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), 'resaSamediMidi',],
            ['samedi',   new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), 'resaSamediSoir',],
            ['dimanche', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), 'resaDimancheMidi',],
        ];

        foreach ($ouvertureExamples as [$jSem, $openH, $closeH, $resa]) {
            $opening = new OuvertureHebdo();
            $opening->setJourSemaine($jSem);
            $opening->setHOuverture($openH);
            $opening->setHFermeture($closeH);
            $manager->persist($opening);
            $this->setReference($resa, $opening);
        }

        $manager->flush();
    }
}
