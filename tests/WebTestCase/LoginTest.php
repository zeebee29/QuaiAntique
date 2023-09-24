<?php

namespace App\tests\WebTestCase;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginTest extends WebTestCase
{

    public function testLoginSuccess()
    {
      $client = static::createClient();

      $userRepository = static::getContainer()->get(UserRepository::class);
      $testUser = $userRepository->findOneById('2');
      $client->logInUser($testUser);

      $client->request('GET', '/user/edition/2');
      $this->assertResponseIsSuccessful();
      $this->assertPageTitleContains('informations');
      
      $client->request('GET', '/user/history/2');
      $this->assertResponseIsSuccessful();
      $this->assertPageTitleContains('Historique');
    }
}
