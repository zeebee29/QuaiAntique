<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Generator;
use Faker\Factory;

class UserFixtures extends Fixture
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
        $allergene = [
            null,
            'Céréales contenant du gluten (blé, seigle, orge, avoine, épeautre, Kamut ou leurs souches hybrides) et produits à base de ces céréales',
            'Œufs et produits à base d’œuf',
            'Poissons et produits à base de poisson',
            'Lait et produits à base de lait',
            'Fruits à coques (amandes, noisettes, noix, noix de cajou, noix de pécan, noix du Brésil, noix de macadamia, noix du Queensland, pistaches) et produits à base de ces fruits',
            'Anhydride sulfureux et sulfites en concentration de plus de 10 mg/kg ou 10 mg/l (exprimés en SO2)',
            'Arachide et produits à base d’arachide',
            'Crustacés et produits à base de crustacés',
            'Soja et produits à base de soja',
            'Céleri et produits à base de céleri',
            'Moutarde et produits à base de moutarde',
            'Graines de sésame et produits à base de graines de sésame',
        ];

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setNom($this->faker->lastName())
                ->setPrenom(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setTel($this->faker->regexify('/^(\+33|0)[1-9]{9}$/'))
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password')
                ->setNbConvive(mt_rand(1, 4))
                ->setAllergie($allergene[mt_rand(0, count($allergene) - 1)])
                ->setUpdatedAt(new \DateTime());

            if ($i < 3) {
                $this->setReference("user$i", $user);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
