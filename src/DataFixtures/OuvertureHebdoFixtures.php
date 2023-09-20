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
            ['1', 'Lun', 'midi', null, null, 'Fermé', 'resaLundiMidi',],
            ['1', 'Lun', 'soir', null, null, 'Fermé', 'resaLundiSoir',],
            ['2', 'Mar', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaMardiMidi',],
            ['2', 'Mar', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaMardiSoir',],
            ['3', 'Mer', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaMardiMidi',],
            ['3', 'Mer', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaMardiSoir',],
            ['4', 'Jeu', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaJeudiMidi',],
            ['4', 'Jeu', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaJeudiSoir',],
            ['5', 'Ven', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaVendrediMidi',],
            ['5', 'Ven', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaVendrediSoir',],
            ['6', 'Sam', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaSamediMidi',],
            ['6', 'Sam', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaSamediSoir',],
            ['7', 'Dim', 'midi', null, null, 'Fermé', 'resaDimancheMidi',],
            ['7', 'Dim', 'soir', null, null, 'Fermé', 'resaDimancheMidi',],
        ];

        foreach ($ouvertureExamples as [$numJsem, $jSem, $plage, $openH, $closeH, $plageTxt, $resa]) {
            $opening = new OuvertureHebdo();
            $opening->setNumJsem($numJsem);
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
