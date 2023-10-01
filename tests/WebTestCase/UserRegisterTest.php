<?php

namespace App\tests\WebTestCase;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRegisterTest extends WebTestCase
{

  public function getUser (): User
  {
      return(
          new User())
          ->setNom('nomTest')
          ->setPrenom('pre')
          ->setEmail('tst@mail.tst')
          ->setNbConvive(2)
          ->setPlainPassword('Aa*123456798')
          ->setTel('0102030405')
      ;
  }

    public function testRegisterUser()
    {
        $container = static::getContainer();

        $user = $this->getUser();

        $entityManager = $container->get('doctrine')->getManager();

        $entityManager->persist($user);
        $entityManager->flush();

        $userRepository = $entityManager->getRepository(User::class);
        $registeredUser = $userRepository->findOneBy(['nom' => 'nomTest']);

        $this->assertInstanceOf(User::class, $registeredUser);
        $this->assertEquals('tst@mail.tst', $registeredUser->getEmail());
        $entityManager->remove($user);
        $entityManager->flush();        
    }
}