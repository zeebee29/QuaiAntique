<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PageControllerTest extends WebTestCase
{
    public function testRestrictedPageIsRedirect(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testRedirectToRouteHistory():void
    {
        $client = static::createClient();
        $client->request('GET', '/user/history/5');

        $this->assertResponseRedirects('/login');

    }
}
