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
            ['Lundi',    'midi', null, null, 'Fermé', 'resaLundiMidi',],
            ['Lundi',    'soir', null, null, 'Fermé', 'resaLundiSoir',],
            ['Mardi',    'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30:00', 'resaMardiMidi',],
            ['Mardi',    'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00:00', 'resaMardiSoir',],
            ['Mercredi', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30:00', 'resaMardiMidi',],
            ['Mercredi', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00:00', 'resaMardiSoir',],
            ['Jeudi',    'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30:00', 'resaJeudiMidi',],
            ['Jeudi',    'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00:00', 'resaJeudiSoir',],
            ['Vendredi', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30:00', 'resaVendrediMidi',],
            ['Vendredi', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00:00', 'resaVendrediSoir',],
            ['Samedi',   'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30:00', 'resaSamediMidi',],
            ['Samedi',   'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00:00', 'resaSamediSoir',],
            ['Dimanche', 'midi', null, null, 'Fermé', 'resaDimancheMidi',],
            ['Dimanche', 'soir', null, null, 'Fermé', 'resaDimancheMidi',],
        ];

        foreach ($ouvertureExamples as [$jSem, $plage, $openH, $closeH, $plageTxt, $resa]) {
            $opening = new OuvertureHebdo();
            $opening->setJourSemaine($jSem);
            $opening->setPlage($plage);
            $opening->setPlageTxt($plageTxt);
            $opening->setHOuverture($openH);
            $opening->setHFermeture($closeH);
            $manager->persist($opening);
            $this->setReference($resa, $opening);
        }

        $manager->flush();
    }
}
