<?php

namespace App\tests\WebTestCase;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

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
    public function testInvalidRestrictedPage(): void
    {    

        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneById('6');
        $client->logInUser($testUser);
        
        $client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
      }
      public function testValidRestrictedPage(): void
      {    
  
          $client = static::createClient();
  
          $userRepository = static::getContainer()->get(UserRepository::class);
          $testUser = $userRepository->findOneById('10');
          $client->logInUser($testUser);
          
          $client->request('GET', '/admin');
          $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
}
