<?php

namespace App\DataFixtures;

use App\Entity\Image;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{

    private $imagesDirectory;
    private $uploaderHelper;

    public function __construct(UploaderHelper $uploaderHelper)
    {
      $this->uploaderHelper = $uploaderHelper;
      $this->imagesDirectory = 'public/images/restaurant';
    }
    public function load(ObjectManager $manager): void
    {
        $nom="Accueil";
        $imag=1;
         // Récupérez la liste des fichiers d'image existants dans le répertoire
         $imageFiles = scandir($this->imagesDirectory);

       // Parcourez les fichiers d'image et créez une entité Image pour chacun
       foreach ($imageFiles as $filename) {
           // Ignorer les fichiers "." et ".." qui représentent le répertoire parent
           if ($filename === '.' || $filename === '..') {
               continue;
           }
           switch ($imag) {
            case 2:
              $nom="CarrouselH";
              break;
            case 6:
              $nom="Plat";
              break;
            case 10:
              $nom="Nous";
              break;
          }
          $imag++;
           $image = new Image();

           /*// Générez un nom aléatoire pour l'image (ou utilisez le nom du fichier)
           $nom = $this->slugger->slug(pathinfo($filename, PATHINFO_FILENAME))->toString();
           $image->setNom($nom);*/

           $image->setNom($nom);

           // Utilisez le nom de fichier d'origine
           $image->setImageName($filename);

           // Créez un fichier d'image à partir du chemin complet
           $imagePath = $this->imagesDirectory . '/' . $filename;
           $imageFile = new File($imagePath);

           // Associez le fichier à l'entité Image
           $image->setImageFile($imageFile);

           // Vous pouvez utiliser Faker ou définir d'autres données pour votre entité Image, par exemple, la description
           $image->setDescription('Description aléatoire ou spécifique.');
           $image->setRestaurant($this->getReference('restaurant'));

           $manager->persist($image);
       }



/*            
            $image = new Image();
            // Générez un nom de fichier unique pour l'image
            $originalFilename = $this->faker->image('public/images/restaurant', 640, 480, null, false);
            $uniqueFilename = $this->slugger->slug($originalFilename)->toString();

            $image->setImageName($uniqueFilename);

            // Créez un fichier d'image aléatoire avec Faker
            $fakeImagePath = 'public/images/restaurant/' . $originalFilename;
            $fakeFile = new UploadedFile($fakeImagePath, $originalFilename);

            // Associez le fichier à l'entité Image
            $image->setImageFile($fakeFile);
            */
/*
            $image->setDescription("Lorem Ipsum")
            ->setNom($nom);
            $image->setRestaurant($this->getReference('restaurant'));

            
            dd('Nom de fichier : ' . $image->getImageName().
            'Nom image : ' . $image->getNom().
            'fakePath : ' . $fakeImagePath);
  */         /* 
            $manager->persist($image);
            
          }*/
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            RestaurantFixtures::class,
        ];
    }
}
