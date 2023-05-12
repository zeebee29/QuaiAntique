<?php

namespace App\DataFixtures;

use App\Entity\Fermeture;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FermetureFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date1_deb = new DateTime('2023-05-01');
        $date1_fin = new DateTime('2023-05-08');
        $date2_deb = new DateTime('2023-11-01');
        $date2_fin = new DateTime('2023-11-08');
        $ferme1 = new Fermeture();
        $ferme1->setDebutFermeture($date1_deb);
        $ferme1->setFinFermeture($date1_fin);
        $ferme1->setCommentaire('Vacances annuelles 1er semestre');
        $manager->persist($ferme1);

        $ferme2 = new Fermeture();
        $ferme2->setDebutFermeture($date2_deb);
        $ferme2->setFinFermeture($date2_fin);
        $ferme2->setCommentaire('Vacances annuelles 2nd semestre');
        $manager->persist($ferme2);

        $manager->flush();
    }
}
