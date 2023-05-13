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
            ['Lun', 'midi', null, null, 'Fermé', 'resaLundiMidi',],
            ['Lun', 'soir', null, null, 'Fermé', 'resaLundiSoir',],
            ['Mar', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaMardiMidi',],
            ['Mar', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaMardiSoir',],
            ['Mer', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaMardiMidi',],
            ['Mer', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaMardiSoir',],
            ['Jeu', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaJeudiMidi',],
            ['Jeu', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaJeudiSoir',],
            ['Ven', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaVendrediMidi',],
            ['Ven', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaVendrediSoir',],
            ['Sam', 'midi', new DateTime('2020-01-01 12:00:00'), new DateTime('2020-01-01 14:30:00'), '12:00 - 14:30', 'resaSamediMidi',],
            ['Sam', 'soir', new DateTime('2020-01-01 19:00:00'), new DateTime('2020-01-01 22:00:00'), '19:00 - 22:00', 'resaSamediSoir',],
            ['Dim', 'midi', null, null, 'Fermé', 'resaDimancheMidi',],
            ['Dim', 'soir', null, null, 'Fermé', 'resaDimancheMidi',],
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
